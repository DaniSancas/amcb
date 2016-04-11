<?php

namespace Amcb\AppBundle\Controller;

use Amcb\AppBundle\Entity\Fichero;
use Amcb\AppBundle\Form\Type\FicheroType;
use Amcb\AppBundle\Library\Util;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

/**
 * Class FicheroController
 *
 * @package Amcb\AppBundle\Controller
 *
 * @Route("/privado")
 */
class FicheroController extends Controller
{
    /**
     * Acción que muestra el formulario de login para acceder al área privada.
     *
     * Si el usuario ya está logeado y dispone de los permisos mínimos, nos saltamos el login.
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/login", name="private_login", methods={"GET"})
     * @Template()
     */
    public function loginAction(Request $request)
    {
        // Obtenemos el servicio de seguridad y el usuario logeado en la aplicación.
        $securityContext = $this->container->get('security.authorization_checker');
        $user = $this->getUser();

        // Si el usuario logeado está autenticado y tiene rango suficiente, redirigimos a la página de inicio privado.
        if($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') && $user && $user->getRango() >= 1) {
            return $this->redirect($this->generateUrl('private_homepage'));
        }

        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                Security::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }

        return array(
            // last username entered by the user
            'last_username' => $session->get(Security::LAST_USERNAME),
            'error'         => $error,
        );
    }

    /**
     * Ácción que muestra el listado de Ficheros.
     *
     * @param Request $request
     * @return array
     *
     * @Route("/", name="private_fichero_listado", methods={"GET"})
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $filtro = $request->get("filtro");

        $findBy = (null !== $filtro) ? array("categoria" => $filtro) : array();

        $ficheros = $this->getDoctrine()->getRepository('AppBundle:Fichero')->findBy($findBy, array('fechaCreacion' => 'DESC'));

        return array('ficheros' => $ficheros, 'categorias' => Util::getCategorias(true), 'filtro' => $filtro);
    }

    /**
     * Acción que muestra el Fichero y permite descargar el archivo asociado.
     *
     * @param Fichero $fichero
     * @return array
     *
     * @Route("/fichero/ver/{id}", name="private_fichero_ver", requirements={"id"="\d+"}, methods={"GET"})
     * @Template()
     */
    public function verAction(Fichero $fichero)
    {
        return array('fichero' => $fichero);
    }

    /**
     * Acción que muestra y procesa el formulario para las rutas nuevo, editar y guardar un Fichero.
     *
     * Para editar y guardar un Fichero, solo lo podrán hacer el autor o un SUPER_ADMIN.
     *
     * @param Request $request
     * @param null $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     *
     * @Route("/fichero/subir", name="private_fichero_nuevo", methods={"GET"})
     * @Route("/fichero/editar/{id}", name="private_fichero_editar", requirements={"id"="\d+"}, methods={"GET"})
     * @Route("/fichero/guardar/{id}", name="private_fichero_guardar", requirements={"id"="\d+"}, methods={"POST"})
     * @Template()
     */
    public function formAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        // Se se ha especificado una ID, recuperamos el fichero. En caso contrario creamos uno nuevo.
        $fichero = (null === $id) ? new Fichero() : $em->getRepository('AppBundle:Fichero')->find($id);

        // Lanzar Exception si:
        // - El rango es menor de 2 (menor que ROLE_ADMIN, sin permisos de escritura)
        // - En caso de no ser un fichero nuevo, si el usuario no es el autor o no tiene rango 3: permiso de ROLE_SUPER_ADMIN
        if(($this->getUser()->getRango() < 2) ||
            ((null !== $fichero && $fichero->getId() != 0) && ($fichero->getUsuario() != $this->getUser() && $this->getUser()->getRango() < 3))) {
            throw $this->createNotFoundException('El fichero requerido no existe o no tiene permiso para acceder a él.');
        }

        // Creamos el formulario
        $params = (null === $fichero) ? array() : array('id' => $fichero->getId());
        $formulario = $this->createForm(new FicheroType(), $fichero, array(
            'action' => $this->generateUrl('private_fichero_guardar', $params),
            'method' => 'POST',
        ));

        $formulario->handleRequest($request);

        if($formulario->isValid())
        {
            // Si es nuevo
            if(null === $fichero->getId())
            {
                $esNuevo = true;
                $fichero->setUsuario($this->getUser());

                $em->persist($fichero); // Insert
            }else{
                $esNuevo = false;
                // Necesario si lo único que se cambia es el fichero,
                // en caso contrario no guarda nada al creer que nada ha sido modificado.
                $fichero->preUpload();

                $em->merge($fichero);   // Update
            }

            $em->flush();

            if($esNuevo)
            {
                // Mandamos email de alerta a los usuarios
                $usuarios = $em->getRepository('AppBundle:Usuario')->getWithEmail();

                if(count($usuarios) && (null !== $usuarios))
                {
                    $url = $this->generateUrl('private_fichero_ver', array('id' => $fichero->getId()), true);

                    foreach($usuarios as $usuario)
                    {
                        $message = \Swift_Message::newInstance()
                            ->setSubject('[www.amcb.es] Nuevo fichero subido')
                            ->setFrom("no-reply@amcb.es", "AMCB")
                            ->setTo($usuario->getEmail(), $usuario->getUsuario())
                            ->setBody(
                                $this->renderView(
                                    'AppBundle:Fichero:emailNuevoFichero.txt.twig',
                                    array(
                                        'autor' => $fichero->getUsuario(),
                                        'titulo' => $fichero->getTitulo(),
                                        'descripcion' => $fichero->getDescripcion(),
                                        'categoria' => $fichero->getCategoriaElegida(),
                                        'enlace' => $url,
                                        'descarga' => $fichero->getFicheroWeb()
                                    )
                                )
                            );

                        $this->get('mailer')->send($message);
                    }
                }
            }

            $this->get('session')->getFlashBag()->add('ok', 'Fichero guardado con éxito.');

            return $this->redirect($this->generateUrl('private_fichero_listado'));
        }

        return array('form' => $formulario->createView());
    }

    /**
     * Acción que elimina un Fichero.
     *
     * Solo lo podrán eliminar el autor o un SUPER_ADMIN.
     *
     * @param Fichero $fichero
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/fichero/eliminar/{id}", name="private_fichero_eliminar", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function eliminarAction(Fichero $fichero)
    {
        $em = $this->getDoctrine()->getManager();

        // Si el usuario logeado no es el autor o no tiene permiso de ROLE_SUPER_ADMIN
        if($fichero->getUsuario() != $this->getUser() && $this->getUser()->getRango() < 3) {
            throw $this->createNotFoundException('El fichero requerido no existe o no tiene permiso para acceder a él.');
        }

        $em->remove($fichero);
        $em->flush();

        $this->get('session')->getFlashBag()->add('ok', 'Fichero eliminado con éxito.');

        return $this->redirect($this->generateUrl('private_fichero_listado'));
    }
}
