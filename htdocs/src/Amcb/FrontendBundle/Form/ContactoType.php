<?php
namespace Amcb\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\Container as Container;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
      'belen'   => 'Belén - Secretaría de la Asociación',
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
   * 
   * 
   * @param string $nombre
   * @return string|null
   */
  public static function getEmailDestinatario($nombre, Container $container)
  {
      switch ($nombre) {
          case 'txema':
              return $container->getParameter('presidente_email');
              break;
          case 'belen':
              return $container->getParameter('secretaria_email');
              break;
          case 'dani':
              return $container->getParameter('webmaster_email');
              break;
          default:
              return null;
              break;
      }
  }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('destinatario', 'choice', array(
                'required' => true,
                'choices' => $this->getDestinatarios()
            ))
            ->add('nombre', 'text', array(
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'Especifique su nombre...'
                )
            ))
            ->add('apellidos', 'text', array(
                'trim' => true,
                'required' => false
            ))
            ->add('telefono', 'text', array(
                'trim' => true,
                'required' => false
            ))
            ->add('email', 'email', array(
                'trim' => true,
                'attr' => array(
                    'placeholder' => 'Especifique su email...'
                )
            ))
            ->add('consulta', 'textarea', array(
                'attr' => array(
                    'placeholder' => 'Por favor, escriba su consulta...'
                )
            ))
        ;
    }
  
    public function setDefaultOptions(OptionsResolverInterface $resolver)
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
                    'maxMessage' => 'Nombre demasiado corto. Debe contener {{ limit }} caracteres como mínimo.',
                    'minMessage' => 'Nombre demasiado largo. Debe contener {{ limit }} caracteres como máximo.'
                ))
            ),
            'apellidos' => array(),
            'telefono' => array(),
            'consulta' => array(
                new NotBlank(array('message' => 'Debe escribir su consulta.')),
                new Length(array(
                    'min' => 25, 
                    'max' => 1000, 
                    'maxMessage' => 'Texto demasiado corto. Debe contener {{ limit }} caracteres como mínimo.',
                    'minMessage' => 'Texto demasiado largo. Debe contener {{ limit }} caracteres como máximo.'
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

  public function getName()
  {
    return 'contacto';
  }
}
?>
