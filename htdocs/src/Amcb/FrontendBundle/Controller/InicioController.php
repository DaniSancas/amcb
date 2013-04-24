<?php

namespace Amcb\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Amcb\FrontendBundle\Form\ContactoType;

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
        $contacto = new ContactoType();

        $form = $this->createForm(new ContactoType(), $contacto);

        return array('form' => $form->createView());

    }
}
