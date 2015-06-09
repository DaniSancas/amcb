<?php

namespace Amcb\AppBundle\Twig\Extension;

/**
 * Extensión de Twig que permite filtrar fechas para mostrarlas en formato largo y en castellano.
 * 
 */
class SpanishDateTimeExtension extends \Twig_Extension
{

    /**
     * {@inheritDoc}
     */
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

    /**
     * Formato: 1 Enero
     *
     * @param $d
     * @return string
     */
    public function fechaMuyCortaFilter($d)
    {
        $this->formater($d, $semana, $mes);
        
        return strftime("%d ".$mes, $d);
    }

    /**
     * Formato: lunes, 1 de Enero
     *
     * @param $d
     * @return string
     */
    public function fechaCortaFilter($d)
    {
        $this->formater($d, $semana, $mes);
        
        return strftime($semana.", %d de ".$mes, $d);
    }

    /**
     * Formato: lunes, 1 de Enero de 2000
     *
     * @param $d
     * @return string
     */
    public function fechaLargaFilter($d)
    {
        $this->formater($d, $semana, $mes);
        
        return strftime($semana.", %d de ".$mes." de %Y", $d);
    }

    /**
     * Formato: lunes, 1 de Enero a las 17:00
     *
     * @param $d
     * @return string
     */
    public function fechaHoraCortaFilter($d)
    {
        $this->formater($d, $semana, $mes);
        
        return strftime($semana.", %d de ".$mes." a las %H:%M", $d);
    }

    /**
     * Formato: lunes, 1 de Enero de 2000 a las 17:00
     *
     * @param $d
     * @return string
     */
    public function fechaHoraLargaFilter($d)
    {
        $this->formater($d, $semana, $mes);
        
        return strftime($semana.", %d de ".$mes." de %Y a las %H:%M", $d);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'pre_spanish_date_twig_extension';
    }
    
    //--------------------------------------------------------------------------

    /**
     * Recibe como parámetros de referencia día del mes, de la semana y mes del año.
     *
     * Evalúa &$d y convierte los parámetros a sus respectivos resultados:
     *
     * @param $d \DateTime|String Día del mes
     * @param $semana String Día de la semana
     * @param $mes String Mes del año
     */
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
