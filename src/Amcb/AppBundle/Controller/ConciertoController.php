<?php

namespace Amcb\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * Class ConciertoController
 *
 * @package Amcb\AppBundle\Controller
 *
 * @Cache(expires="+1 days", maxage="86400", smaxage="86400", public="true")
 */
class ConciertoController extends Controller
{
    /**
     * Acción que muestra la página de próximos conciertos.
     *
     * @Route("/conciertos/proximos", name="conciertos", methods={"GET"})
     * @Template()
     */
    public function indexAction()
    {
        $conciertos = $this->getDoctrine()->getManager()->getRepository('AppBundle:Concierto')->getProximos();

        return array('conciertos' => $conciertos);
    }
    
    /**
     * Acción que muestra la página del archivo de conciertos.
     * 
     * La información se mostrará paginada por años.
     *
     * @Route("/conciertos/archivo", name="archivo_conciertos", methods={"GET"})
     * @Route("/conciertos/archivo/{pag}", name="archivo_conciertos_pag", requirements={"pag"="\d+"}, methods={"GET"})
     * @Template()
     */
    public function archivoAction()
    {
        $paginas = $this->getDoctrine()->getManager()->getRepository('AppBundle:Concierto')->getPeriodosPaginacion();
        
        $request = $this->get('request');
        
        $actual = null;
        if(null !== $request->get('pag'))
        {
            $countPags = count($paginas);
            for($i = 0; $i < $countPags; $i++)
            {
                if($paginas[$i]['year'] == $request->get('pag'))
                {
                    $actual = $request->get('pag');
                    break;
                }
            }
        }
        
        if(null === $actual)
            $actual = $paginas[0]['year'];
        
        $conciertos = $this->getDoctrine()->getManager()->getRepository('AppBundle:Concierto')->getPasados($actual);

        return array('paginas' => $paginas, 'actual' => $actual, 'conciertos' => $conciertos);
    }
    
    /**
     * Acción que muestra la página de un concierto con toda su información al completo.
     *
     * @param $id
     * @return array
     *
     * @Route("/concierto/{fecha_larga}/{slug}/{id}", name="mostrar_concierto", requirements={"id"="\d+"}, methods={"GET"})
     * @Template()
     */
    public function mostrarAction($id)
    {
        $concierto = $this->getDoctrine()->getManager()->getRepository('AppBundle:Concierto')->find($id);

        return array('concierto' => $concierto);
    }
}
?>
