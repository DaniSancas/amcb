<?php

namespace Amcb\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Amcb\AppBundle\Form\Type\ContactoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Cache(expires="+3 days", maxage="259200", smaxage="259200", public="true")
 */
class GeneralController extends Controller
{
    /**
     * Acción que muestra la página de inicio.
     *
     * @Route("/", name="homepage", methods={"GET"})
     * @Cache(maxage="60", smaxage="60", public="true")
     * @Template()
     */
    public function indexAction()
    {
        $conciertos = $this->getDoctrine()->getRepository('AppBundle:Concierto')->getProximos(5);

        return array('conciertos' => $conciertos);
    }
    
    /**
     * Acción que muestra la página de la historia de la AMCB.
     *
     * @Route("/historia", name="historia", methods={"GET"})
     * @Template()
     */
    public function historiaAction()
    {
        return array();
    }
    
    /**
     * Acción que muestra la página donde incrustamos vídeos para que nos vean y oigan.
     *
     * @Route("/escuchanos", name="escuchanos", methods={"GET"})
     * @Template()
     */
    public function escuchanosAction()
    {
        $videos = array('51wG0qBLBWY', 'UzY-YCPFemw', 'fQN6qq0NS4E', 'pywyQqs26rA', 'WM7Gn52NkO0', '8Wa7IGE4zwo',
            'YvYgd5KdNTo');

        return array('videos' => $videos);
    }
    
    /**
     * Acción que muestra la página donde se presenta el repertorio.
     *
     * @Route("/repertorio", name="repertorio", methods={"GET"})
     * @Template()
     */
    public function repertorioAction()
    {
        return array();
    }
    
    /**
     * Acción que muestra la página donde se muestran los documentos de interés.
     *
     * @Route("/documentos-interes", name="docsInteres", methods={"GET"})
     * @Template()
     */
    public function documentosAction()
    {
        return array();
    }
    
    /**
     * Acción que muestra la galería de fotos.
     *
     * @Route("/galeria", name="galeria", methods={"GET"})
     * @Template()
     */
    public function galeriaAction()
    {
        return array();
    }

    /**
     * Acción que muestra y procesa el formulario de contacto.
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/contacto", name="contacto", methods={"GET"})
     * @Route("/contacto", name="contacto_submit", methods={"POST"})
     * @Cache(expires="-1 days", maxage="0", smaxage="0", public="true")
     * @Template()
     */
    public function contactoAction(Request $request)
    {
        $form = $this->createForm(new ContactoType());

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $message = \Swift_Message::newInstance()
                    ->setSubject('[www.amcb.es] Consulta desde la web')
                    ->setFrom($form->get('email')->getData())
                    ->setTo($this->getEmailDestinatario($form->get('destinatario')->getData()))
                    ->setBody(
                        $this->renderView(
                            'AppBundle:General:emailContacto.txt.twig',
                            array(
                                'nombre' => $form->get('nombre')->getData(),
                                'apellidos' => $form->get('apellidos')->getData(),
                                'email' => $form->get('email')->getData(),
                                'telefono' => $form->get('telefono')->getData(),
                                'consulta' => $form->get('consulta')->getData()
                            )
                        )
                    );

                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('ok', 'Se ha enviado su email. Gracias por contactar con nosotros.');

                return $this->redirect($this->generateUrl('contacto'));
            }
        }

        return array('form' => $form->createView(),
            'presidente_email' => $this->container->getParameter('presidente_email'),
            'secretaria_email' => $this->container->getParameter('secretaria_email'),
            'webmaster_email' => $this->container->getParameter('webmaster_email'));

    }

    /**
     * Devuelve el email correspondiente a la persona de contacto elegida.
     *
     * @param string $nombre
     * @return string|null
     */
    private function getEmailDestinatario($nombre) {
        switch ($nombre) {
            case 'txema':
                $email = 'presidente_email';
                break;
            case 'belen':
                $email = 'secretaria_email';
                break;
            case 'dani':
                $email = 'webmaster_email';
                break;
            default:
                return null;
                break;
        }

        return $this->container->getParameter($email);
    }
}
