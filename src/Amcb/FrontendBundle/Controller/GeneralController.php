<?php

namespace Amcb\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

use Amcb\CommonBundle\Form\Type\ContactoType;

/**
 * @Cache(expires="+3 days", maxage="259200", smaxage="259200", public="true")
 */
class GeneralController extends Controller
{
    /**
     * Acción que muestra la página de inicio.
     * 
     * @Cache(maxage="60", smaxage="60", public="true")
     * @Template()
     */
    public function indexAction()
    {
        $conciertos = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Concierto')->getProximos(5);

        return array('conciertos' => $conciertos);
    }
    
    /**
     * Acción que muestra la página de la historia de la AMCB.
     * 
     * @Template()
     */
    public function historiaAction()
    {
        return array();
    }
    
    /**
     * Acción que muestra la página donde incrustamos vídeos para que nos vean y oigan.
     * 
     * @Template()
     */
    public function escuchanosAction()
    {
        return array();
    }
    
    /**
     * Acción que muestra la página donde se presenta el repertorio.
     * 
     * @Template()
     */
    public function repertorioAction()
    {
        return array();
    }
    
    /**
     * Acción que muestra la página donde se muestran los documentos de interés.
     * 
     * @Template()
     */
    public function documentosAction()
    {
        return array();
    }
    
    /**
     * Acción que muestra la galería de fotos.
     * 
     * @Template()
     */
    public function galeriaAction()
    {
        return array();
    }
    
    /**
     * Acción que muestra y procesa el formulario de contacto.
     * 
     * @Cache(expires="-1 days", maxage="0", smaxage="0", public="true")
     * @Template()
     */
    public function contactoAction()
    {
        $form = $this->createForm(new ContactoType());
        
        $request = $this->get('request');
        
        if ($request->isMethod('POST'))
        {
            $form->submit($request);

            if ($form->isValid())
            {
                $message = \Swift_Message::newInstance()
                    ->setSubject('[www.amcb.es] Consulta desde la web')
                    ->setFrom($form->get('email')->getData())
                    ->setTo($this->getEmailDestinatario($form->get('destinatario')->getData()))
                    ->setBody(
                        $this->renderView(
                            'FrontendBundle:General:emailContacto.txt.twig',
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

        return array('form' => $form->createView());

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
