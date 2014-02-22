<?php

namespace Amcb\CommonBundle\Sonata;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ConciertoAdmin extends Admin
{
    /**
     * Overriden values to the datagrid
     *
     * @var array
     */
    protected $datagridValues = array(
        #'_page'       => 1,
        '_sort_order' => 'DESC',
        #'_per_page'   => 25,
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('tipo')
            ->add('lugar')
            ->add('fecha', 'datetime', array('years' => range(2008, (date('Y') + 1)), 'minutes' => array(0, 15, 30, 45)))
            ->add('noticia')                
            ->add('es_visible', null,       array('required' => false))
            ->add('maps',       null,       array('required' => false))
            ->add('es_gratis',  null,       array('required' => false))
            ->add('entradas',   'ckeditor', array('config_name' => 'mini', 'required' => false))
            ->add('programa',   'ckeditor', array('config_name' => 'default', 'required' => false))
            ->add('direccion')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('tipo')
            ->add('lugar')
            ->add('fecha')
            ->add('noticia')
            ->add('es_visible')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('lugar')
            ->add('fecha', null, array('format' => 'D, d M y, H:i'))
            ->add('noticia')
            ->add('es_visible')
        ;
    }
}
?>
