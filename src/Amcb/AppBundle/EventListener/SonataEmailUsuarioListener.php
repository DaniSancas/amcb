<?php

namespace Amcb\AppBundle\EventListener;

use Sonata\AdminBundle\Event\PersistenceEvent;

class SonataEmailUsuarioListener
{
    private $mailer = null;
    private $templating = null;

    public function __construct(\Swift_Mailer $mailer, $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function onNewUsuario(PersistenceEvent $event)
    {
        $usuario = $event->getObject();

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
            )
        ;
        $this->mailer->send($message);
    }
}