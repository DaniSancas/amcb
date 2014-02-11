<?php

namespace Amcb\PrivateBundle\Controller;

use Amcb\CommonBundle\Entity\Fichero;
use Amcb\CommonBundle\Form\FicheroType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FicheroController extends Controller
{
    /**
     * Ácción que muestra el listado de Ficheros.
     *
     * @Template()
     */
    public function indexAction()
    {
        $ficheros = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Fichero')->findBy(array(), array('fechaCreacion' => 'DESC'));

        return array('ficheros' => $ficheros);
    }

    /**
     * Acción que muestra el Fichero y permite descargar el archivo asociado.
     *
     * @Template()
     */
    public function verAction($id)
    {
        $fichero = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Fichero')->find($id);

        if(!$fichero)
            throw new NotFoundHttpException('El fichero requerido no existe o no tiene permiso para acceder a él.');

        return array('fichero' => $fichero);
    }

    /**
     * Acción que muestra y procesa el formulario para las rutas nuevo, editar y guardar un Fichero.
     *
     * Para editar y guardar un Fichero, solo lo podrán hacer el autor o un SUPER_ADMIN.
     *
     * @Template()
     */
    public function formAction(Request $request, $id = null)
    {
        $em = $this->getDoctrine()->getManager();

        $fichero = (null === $id) ? new Fichero() : $em->getRepository('CommonBundle:Fichero')->find($id);

        // Si no existe el registro ni (el usuario logeado es el autor o ni tiene permiso de ROLE_SUPER_ADMIN)
        if(($this->getUser()->getRango() < 2) || ((null !== $id) && (!$fichero || ($fichero->getUsuario() != $this->getUser() && $this->getUser()->getRango() < 3))))
            throw new NotFoundHttpException('El fichero requerido no existe o no tiene permiso para acceder a él.');

        $params = (null === $id) ? array() : array('id' => $id);
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
                $fichero->setUsuario($this->getUser());
                $em->persist($fichero); // Insert
            }else{
                // Necesario si lo único que se cambia es el fichero,
                // en caso contrario no guarda nada al creer que nada ha sido modificado.
                $fichero->preUpload();

                $em->merge($fichero);   // Update
            }

            $em->flush();

            $this->get('session')->getFlashBag()->add('ok', 'Fichero guardado con éxito.');

            return $this->redirect($this->generateUrl('private_fichero_listado'));
        }

        return array('formulario' => $formulario->createView());
    }

    /**
     * Acción que elimina un Fichero.
     *
     * Solo lo podrán eliminar el autor o un SUPER_ADMIN.
     */
    public function eliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $fichero = $em->getRepository('CommonBundle:Fichero')->find($id);

        // Si no existe el registro ni (el usuario logeado es el autor o ni tiene permiso de ROLE_SUPER_ADMIN)
        if(!$fichero || ($fichero->getUsuario() != $this->getUser() && $this->getUser()->getRango() < 3))
            throw new NotFoundHttpException('El fichero requerido no existe o no tiene permiso para acceder a él.');

        $em->remove($fichero);
        $em->flush();

        $this->get('session')->getFlashBag()->add('ok', 'Fichero eliminado con éxito.');

        return $this->redirect($this->generateUrl('private_fichero_listado'));
    }
}
