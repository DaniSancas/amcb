<?php

namespace Amcb\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * Class MiembroController
 *
 * @package Amcb\AppBundle\Controller
 *
 * @Route("/miembros")
 * @Cache(expires="+3 days", maxage="259200", smaxage="259200", public="true")
 */
class MiembroController extends Controller
{
    /**
     * Acción que muestra la página del coro
     *
     * @Route("/coro", name="coro", methods={"GET"})
     * @Template()
     */
    public function coroAction()
    {
        return array();
    }
    
    /**
     * Acción que muestra la página de la orquesta
     *
     * @Route("/orquesta", name="orquesta", methods={"GET"})
     * @Template()
     */
    public function orquestaAction()
    {
        return array();
    }
    
    /**
     * Acción que muestra la página de la junta directiva
     *
     * @Route("/junta-directiva ", name="juntaDirectiva", methods={"GET"})
     * @Template()
     */
    public function juntaAction()
    {
        return array();
    }
    
    /**
     * Ficha de María Montes
     *
     * @Route("/maria-montes", name="ficha_maria_montes", methods={"GET"})
     * @Template()
     */
    public function mariaMontesAction()
    {
        return array();
    }
    
    /**
     * Ficha de Elena Roldán
     *
     * @Route("/elena-roldan", name="ficha_elena_roldan", methods={"GET"})     *
     * @Template()
     */
    public function elenaRoldanAction()
    {
        return array();
    }

    /**
     * Ficha de Hilario Extremiana
     *
     * @Route("/hilario-extremiana", name="ficha_hilario_extremiana", methods={"GET"})     *
     * @Template()
     */
    public function hilarioExtremianaAction()
    {
        return array();
    }
    
    /**
     * Ficha de Paula Pérez
     *
     * @Route("/paula-perez", name="ficha_paula_perez", methods={"GET"})
     * @Template()
     */
    public function paulaPerezAction()
    {
        return array();
    }
    
    /**
     * Ficha de Txaber Fernández
     *
     * @Route("/txaber-fernandez", name="ficha_txaber_fernandez", methods={"GET"})
     * @Template()
     */
    public function txaberFernandezAction()
    {
        return array();
    }
    
    /**
     * Ficha de Alain Sancho
     *
     * @Route("/alain-sancho", name="ficha_alain_sancho", methods={"GET"})
     * @Template()
     */
    public function alainSanchoAction()
    {
        return array();
    }
}
?>
