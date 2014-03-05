<?php

namespace Amcb\CommonBundle\Twig\Extension;

class ExtraFilterExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'decode' => new \Twig_Filter_Method($this, 'decode')
        );
    }

    public function decode($string)
    {
        return html_entity_decode($string);
    }

    public function getName()
    {
        return 'extra_filter_twig_extension';
    }
}

?>
