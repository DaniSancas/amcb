<?php
namespace Amcb\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactoType extends AbstractType
{
  
  public $destinatario;
  
  public $nombre;
  
  public $apellidos;
  
  public $email;
  
  public $consulta;
  
  
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('destinatario', 'choice', array(
          'choices' => array(
              'txema' => 'Txema - Presidente y Rel. Públicas',
              'belen' => 'Belén - Secretaría de la Asociación',
              'dani'  => 'Dani - Webmaster'
          )
      ))
      ->add('nombre')
      ->add('apellidos', 'text', array(
          'required' => false
      ))
      ->add('email')
      ->add('consulta', 'textarea')
    ;
  }

  public function getName()
  {
    return 'contacto';
  }
}
?>
