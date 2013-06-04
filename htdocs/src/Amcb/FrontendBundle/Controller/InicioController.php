<?php

namespace Amcb\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Amcb\CommonBundle\Form\ContactoType;

class InicioController extends Controller
{
    /**
     * 
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function historiaAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function escuchanosAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function repertorioAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function documentosAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function contactoAction()
    {
        $form = $this->createForm(new ContactoType());
        
        $request = $this->get('request');
        
        if ($request->isMethod('POST'))
        {
            $form->bind($request);

            if ($form->isValid())
            {
                $message = \Swift_Message::newInstance()
                    ->setSubject('[www.amcb.es] Consulta desde la web')
                    ->setFrom($form->get('email')->getData())
                    ->setTo(ContactoType::getEmailDestinatario($form->get('destinatario')->getData(), $this->container))
                    ->setBody(
                        $this->renderView(
                            'FrontendBundle:Inicio:emailContacto.txt.twig',
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
}
