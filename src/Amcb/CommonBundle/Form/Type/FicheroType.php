<?php

namespace Amcb\CommonBundle\Form\Type;

use Amcb\CommonBundle\Library\Util;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->add('id', 'hidden')
            ->add('titulo', null, array('label' => 'Título'))
            ->add('categoria', 'choice', array('choices' => Util::getCategorias(), 'label' => 'Categoría'))
            ->add('descripcion','ckeditor', array('label' => 'Descripción', 'config_name' => 'mini', 'required' => false))
            ->add('guardar', 'submit', array('attr' => array('class' => 'btn btn btn-success')))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event){
            $fichero = $event->getData();
            $form = $event->getForm();

            // Si es nuevo, que el Fichero sea obligatorio.
            $required = (!$fichero || null === $fichero->getId());
            $form->add('file', 'file', array('required' => $required, 'position' => array('before' => 'guardar'), 'label' => 'Fichero', 'attr' => array('class' => 'input-file-inline')));
        });
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
