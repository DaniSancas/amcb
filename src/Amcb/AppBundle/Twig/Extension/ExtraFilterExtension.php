<?php

namespace Amcb\AppBundle\Twig\Extension;

use Amcb\AppBundle\Library\Util;

class ExtraFilterExtension extends \Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('decode', function ($string) {
                return html_entity_decode($string, null, "UTF-8");
            }),
            new \Twig_SimpleFilter('coma_separated_string', function ($string) {
                return Util::getComaSeparatedString($string);
            })
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'extra_filter_twig_extension';
    }
}

?>
