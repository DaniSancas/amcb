<?php

namespace Amcb\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FicheroType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', null, array('label' => 'Título'))
            ->add('descripcion', null, array('label' => 'Descripción'))
            ->add('file', 'file', array('label' => 'Fichero', 'attr' => array('class' => 'input-file-inline')))
            ->add('guardar', 'submit', array('attr' => array('class' => 'btn btn btn-success')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Amcb\CommonBundle\Entity\Fichero'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fichero';
    }
}
