<?php

namespace Amcb\AppBundle\Controller;

use Amcb\AppBundle\Entity\Concierto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

/**
 * Class ConciertoController
 *
 * @package Amcb\AppBundle\Controller
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
        $conciertos = $this->getDoctrine()->getRepository('AppBundle:Concierto')->getProximos();

        return array('conciertos' => $conciertos);
    }
    
    /**
     * Acción que muestra la página del archivo de conciertos.
     * 
     * La información se mostrará paginada por años.
     *
     * @param $year int Año de archivo a visualizar.
     * @return array
     *
     * @Route("/conciertos/archivo", name="archivo_conciertos", methods={"GET"})
     * @Route("/conciertos/archivo/{year}", name="archivo_conciertos_pag", requirements={"year"="\d+"}, methods={"GET"})
     * @Template()
     */
    public function archivoAction($year = null)
    {
        // Obtenemos todos los años de conciertos (habrá una página por año)
        $paginas = $this->getDoctrine()->getRepository('AppBundle:Concierto')->getPeriodosPaginacion();

        // Si se ha especificado {year}, obtenemos su página actual
        $actual = null;
        if(null !== $year) {
            $countPags = count($paginas);

            for($i = 0; $i < $countPags; $i++) {
                if($paginas[$i]['year'] == $year) {
                    $actual = $year;
                    break;
                }
            }
        }

        /* En caso de no haberse especificado o no encontrarse,
         * se le asigna el año de archivo más próximo a la fecha actual.
         */
        if(null === $actual) {
            $actual = $paginas[0]['year'];
        }
        
        $conciertos = $this->getDoctrine()->getRepository('AppBundle:Concierto')->getPasados($actual);

        return array('paginas' => $paginas, 'actual' => $actual, 'conciertos' => $conciertos);
    }
    
    /**
     * Acción que muestra la página de un concierto con toda su información al completo.
     *
     * @param Concierto $concierto
     * @return array
     *
     * @Route("/concierto/{fecha_larga}/{slug}/{id}", name="mostrar_concierto", requirements={"id"="\d+"}, methods={"GET"})
     * @Template()
     */
    public function mostrarAction(Concierto $concierto)
    {
        return array('concierto' => $concierto);
    }
}
?>
