<?php

namespace Amcb\CommonBundle\Twig\Extension;

/**
 * Extensión de Twig que permite filtrar fechas para mostrarlas en formato largo y en castellano.
 * 
 */
class SpanishDateTimeExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('fecha_muy_corta', array($this, 'fechaMuyCortaFilter')),
            new \Twig_SimpleFilter('fecha_corta', array($this, 'fechaCortaFilter')),
            new \Twig_SimpleFilter('fecha_larga', array($this, 'fechaLargaFilter')),
            new \Twig_SimpleFilter('fechahora_corta', array($this, 'fechaHoraCortaFilter')),
            new \Twig_SimpleFilter('fechahora_larga', array($this, 'fechaHoraLargaFilter'))
        );
    }
    
    public function fechaMuyCortaFilter($d)
    {
        $this->formater($d, $semana, $mes);
        
        return strftime("%d ".$mes, $d);
    }

    public function fechaCortaFilter($d)
    {
        $this->formater($d, $semana, $mes);
        
        return strftime($semana.", %d de ".$mes, $d);
    }
    
    public function fechaLargaFilter($d)
    {
        $this->formater($d, $semana, $mes);
        
        return strftime($semana.", %d de ".$mes." de %Y", $d);
    }
    
    public function fechaHoraCortaFilter($d)
    {
        $this->formater($d, $semana, $mes);
        
        return strftime($semana.", %d de ".$mes." a las %H:%M", $d);
    }
    
    public function fechaHoraLargaFilter($d)
    {
        $this->formater($d, $semana, $mes);
        
        return strftime($semana.", %d de ".$mes." de %Y a las %H:%M", $d);
    }
        

    public function getName()
    {
        return 'pre_spanish_date_twig_extension';
    }
    
    //--------------------------------------------------------------------------
    
    private function formater(&$d, &$semana, &$mes)
    {
        // Traducciones de días y semanas
        $semanas = array('domingo','lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado');
        $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        
        // La fecha puede venirnos como un datetime o como palabras como "now". 
        if(!$d instanceof \DateTime)
            $d = new \DateTime($d);
        
        $d = $d->getTimestamp();
        
        $semana = $semanas[strftime("%w", $d)];
        $mes = $meses[strftime("%m", $d)-1];
    }
}

?>
