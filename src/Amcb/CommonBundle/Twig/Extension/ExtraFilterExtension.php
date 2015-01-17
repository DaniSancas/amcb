<?php

namespace Amcb\CommonBundle\Twig\Extension;

use Amcb\CommonBundle\Library\Util;

class ExtraFilterExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'decode' => new \Twig_Filter_Method($this, 'decode'),
            'coma_separated_string' => new \Twig_Filter_Method($this, 'comaSeparatedString')
        );
    }

    public function decode($string)
    {
        return html_entity_decode($string, null, "UTF-8");
    }

    /**
     * Llama a la función Util::getComaSeparatedString(), útil para crear keywords separadas por comas.
     *
     * @param $string
     * @return mixed|string
     */
    public function comaSeparatedString($string)
    {
        return Util::getComaSeparatedString($string);
    }

    public function getName()
    {
        return 'extra_filter_twig_extension';
    }
}

?>
