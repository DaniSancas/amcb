<?php

namespace Amcb\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * @Cache(expires="+3 days", maxage="259200", smaxage="259200", public="true")
 */
class MiembroController extends Controller
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
    public function coroAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function orquestaAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function juntaAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function mariaMontesAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function elenaRoldanAction()
    {
        return array();
    }

    /**
     *
     * @Template()
     */
    public function hilarioExtremianaAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function paulaPerezAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function txaberFernandezAction()
    {
        return array();
    }
    
    /**
     * 
     * @Template()
     */
    public function alainSanchoAction()
    {
        return array();
    }
}
?>
