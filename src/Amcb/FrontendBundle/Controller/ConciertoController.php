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
        $conciertos = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Concierto')->getProximos();

        return array('conciertos' => $conciertos);
    }
    
    /**
     * 
     * @Template()
     */
    public function archivoAction()
    {
        $conciertos = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Concierto')->getPasados();

        return array('conciertos' => $conciertos);
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