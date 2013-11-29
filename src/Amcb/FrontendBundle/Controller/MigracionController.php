<?php

namespace Amcb\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MigracionController extends Controller
{
    /**
     * Acción que convierte urls del tipo <code>/programas.php?id=77&tag=concierto-de-camara-en-muskiz</code> en <code>/concierto/sabado-28-de-diciembre-de-2013/concierto-de-camara-en-sondika/77</code>
     */
    public function programasAction()
    {
        $request = $this->get('request');
        
        if(null === $request->get('id'))
            return $this->redirect($this->generateUrl('archivo_conciertos'));
        
        $concierto = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Concierto')->find($request->get('id'));
        
        if($concierto)
        {
            return $this->redirect($this->generateUrl('mostrar_concierto', array('id' => $concierto->getId(), 'fecha_larga' => $concierto->getFechaLarga(), 'slug' => $concierto->getSlug())), 301);
        }else{
            return $this->redirect($this->generateUrl('archivo_conciertos'));
        }
    }
    
    public function pdfAction()
    {
        $request = $this->get('request');
        
        return $this->redirect('/bundles/common/downloads/pdf/'.$request->get('fichero'), 301);
    }
}
?>