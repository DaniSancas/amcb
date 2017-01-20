<?php

namespace Amcb\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactoType extends AbstractType
{
    /**
    * Array() de destinatarios
    *
    * @var array
    */
    private $destinatarios = array(
        ''        => '-- Elija el destinatario --',
        'txema'   => 'Txema - Presidente y Rel. Públicas',
        'lucia'   => 'Lucía - Secretaría de la Asociación',
        'dani'    => 'Dani - Webmaster'
    );

    /**
    * Devuelve el array de destinatarios
    *
    * @return array
    */
    public function getDestinatarios()
    {
        return $this->destinatarios;
    }

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('destinatario', 'choice', array(
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                ),
                'choices' => $this->getDestinatarios()
            ))
            ->add('nombre', 'text', array(
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'Especifique su nombre...',
                    'class' => 'form-control'
                )
            ))
            ->add('apellidos', 'text', array(
                'trim' => true,
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required' => false
            ))
            ->add('telefono', 'text', array(
                'trim' => true,
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required' => false
            ))
            ->add('email', 'email', array(
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'Especifique su email...',
                    'class' => 'form-control'
                )
            ))
            ->add('consulta', 'textarea', array(
                'attr' => array(
                    'placeholder' => 'Por favor, escriba su consulta...',
                    'class' => 'form-control'
                )
            ))
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $collectionConstraint = new Collection(array(
            'destinatario' => array(
                new NotBlank(array('message' => 'Debe elegir un destinatario'))
            ),
            'nombre' => array(
                new NotBlank(array('message' => 'Debe especificar su nombre.')),
                new Length(array(
                    'min' => 3, 
                    'max' => 50, 
                    'minMessage' => 'Nombre demasiado corto. Debe contener {{ limit }} caracteres como mínimo.',
                    'maxMessage' => 'Nombre demasiado largo. Debe contener {{ limit }} caracteres como máximo.'
                ))
            ),
            'apellidos' => array(),
            'telefono' => array(),
            'consulta' => array(
                new NotBlank(array('message' => 'Debe escribir su consulta.')),
                new Length(array(
                    'min' => 25, 
                    'max' => 1000, 
                    'minMessage' => 'Texto demasiado corto. Debe contener {{ limit }} caracteres como mínimo.',
                    'maxMessage' => 'Texto demasiado largo. Debe contener {{ limit }} caracteres como máximo.'
                ))
            ),
            'email' => array(
                new NotBlank(array('message' => 'Debe especificar su email.')),
                new Email(array('message' => 'Dirección de email inválida.'))
            ),
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contacto';
    }
}
?>
