<?php

namespace Amcb\AppBundle\EventListener;

use Sonata\AdminBundle\Event\PersistenceEvent;

class SonataEmailUsuarioListener
{
    private $mailer = null;
    private $templating = null;
    private $secretaria_email = null;

    public function __construct(\Swift_Mailer $mailer, $templating, $secretaria_email)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->secretaria_email = $secretaria_email;
    }

    public function onNewUsuario(PersistenceEvent $event)
    {
        $usuario = $event->getObject();

        if(empty($usuario->getEmail()) || null === $usuario->getEmail()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Usuario/a sin email dado de alta')
                ->setFrom("amcb@sancas.es", "AMCB")
                ->setTo($this->secretaria_email)
                ->setBody(
                    $this->templating->render(
                        'AppBundle:Sonata:emailNuevoUsuarioSecretaria.txt.twig',
                        array(
                            'usuario' => $usuario->getUsuario(),
                            'dni' => $usuario->getDni())
                    )
                );
        }else{
            $message = \Swift_Message::newInstance()
                ->setSubject('Alta en la zona privada de la AMCB')
                ->setFrom("amcb@sancas.es", "AMCB")
                ->setTo($usuario->getEmail(), $usuario->getUsuario())
                ->setBody(
                    $this->templating->render(
                        'AppBundle:Sonata:emailNuevoUsuario.txt.twig',
                        array(
                            'usuario' => $usuario->getUsuario(),
                            'dni' => $usuario->getDni())
                    )
                );
        }

        $this->mailer->send($message);
    }
}