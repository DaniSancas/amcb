<?php

namespace Amcb\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MigracionController extends Controller
{
    /**
     * Acción que convierte urls del tipo <code>/programas.php?id=77&tag=concierto-de-camara-en-muskiz</code> en <code>/concierto/sabado-28-de-diciembre-de-2013/concierto-de-camara-en-sondika/77</code>
     *
     * Redirecciona a la acción deseada.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function programasAction()
    {
        $request = $this->get('request');
        
        if(null === $request->get('id'))
            return $this->redirect($this->generateUrl('archivo_conciertos'));
        
        $concierto = $this->getDoctrine()->getManager()->getRepository('AppBundle:Concierto')->find($request->get('id'));
        
        if($concierto)
        {
            return $this->redirect($this->generateUrl('mostrar_concierto', array('id' => $concierto->getId(), 'fecha_larga' => $concierto->getFechaLarga(), 'slug' => $concierto->getSlug())), 301);
        }else{
            return $this->redirect($this->generateUrl('archivo_conciertos'));
        }
    }
    
    /**
     * Acción que redirige las peticiones de <code>/pdf/*</code> a su nueva ruta.
     * 
     * Devuelve ficheros PDF.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function pdfAction()
    {
        $request = $this->get('request');
        
        return $this->redirect('/bundles/app/downloads/pdf/'.$request->get('fichero'), 301);
    }
    
    /**
     * Acción que redirige las urls del tipo <code>/miembros.php=ficha=Maria_Montes</code> en <code>/miembros/maria-montes</code>
     * 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function fichaMiembroAction()
    {
        $request = $this->get('request');
        
        if(null === $request->get('ficha'))
            return $this->redirect($this->generateUrl('miembros'));
        
        switch($request->get('ficha'))
        {
            case "Maria_Montes":
                return $this->redirect($this->generateUrl('ficha_maria_montes'));
                break;
            case "Elena_Roldan‎":
                return $this->redirect($this->generateUrl('ficha_elena_roldan'));
                break;
            case "Paula_Perez":
                return $this->redirect($this->generateUrl('ficha_paula_perez'));
                break;
            case "Txaber_Fernandez‎":
                return $this->redirect($this->generateUrl('ficha_txaber_fernandez'));
                break;
            case "Alain_Sancho‎":
                return $this->redirect($this->generateUrl('ficha_alain_sancho'));
                break;
            default:
                return $this->redirect($this->generateUrl('miembros'));
                break;
        }
    }
}
?>
