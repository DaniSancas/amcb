<?php

namespace Amcb\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ConciertoController extends Controller
{
    /**
     * Acción que muestra la página de próximos conciertos.
     * 
     * @Template()
     */
    public function indexAction()
    {
        $conciertos = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Concierto')->getProximos();

        return array('conciertos' => $conciertos);
    }
    
    /**
     * Acción que muestra la página del archivo de conciertos.
     * 
     * La información se mostrará paginada por años.
     * 
     * @Template()
     */
    public function archivoAction()
    {
        $paginas = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Concierto')->getPeriodosPaginacion();
        
        $request = $this->get('request');
        
        $actual = null;
        if(null !== $request->get('pag'))
        {
            for($i = 0; $i < count($paginas); $i++)
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
        
        $conciertos = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Concierto')->getPasados($actual);

        return array('paginas' => $paginas, 'actual' => $actual, 'conciertos' => $conciertos);
    }
    
    /**
     * Acción que muestra la página de un concierto con toda su información al completo.
     * 
     * @Template()
     */
    public function mostrarAction($id)
    {
        $concierto = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Concierto')->find($id);

        return array('concierto' => $concierto);
    }
}
?>