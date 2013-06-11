<?php

namespace Amcb\CommonBundle\Sonata;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ConciertoAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('tipo')
            ->add('lugar')
            ->add('fecha')
            ->add('noticia')                
            ->add('es_visible', null,       array('required' => false))
            ->add('maps',       null,       array('required' => false))
            ->add('es_gratis',  null,       array('required' => false))
            ->add('entradas',   'ckeditor', array('config_name' => 'default', 'required' => false))
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
            ->add('fecha')
            ->add('noticia')
            ->add('es_visible')
        ;
    }
}
?>
