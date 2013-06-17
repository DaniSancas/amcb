<?php

namespace Amcb\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ConciertoController extends Controller
{
    /**
     * 
     * @Template()
     */
    public function indexAction()
    {
        $conciertos = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Concierto')->findUltimos();

        return array('conciertos' => $conciertos);
    }
    
    /**
     * 
     * @Template()
     */
    public function archivoAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function mostrarAction()
    {
        return array();
    }
}
?>