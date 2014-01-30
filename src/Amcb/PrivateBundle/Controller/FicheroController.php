<?php

namespace Amcb\PrivateBundle\Controller;

use Amcb\CommonBundle\Entity\Fichero;
use Amcb\CommonBundle\Form\FicheroType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Request;

class FicheroController extends Controller
{
    /**
     * Ácción que muestra el listado de ficheros.
     *
     * @Template()
     */
    public function indexAction()
    {
        $ficheros = $this->getDoctrine()->getManager()->getRepository('CommonBundle:Fichero')->findBy(array(), array('fechaCreacion' => 'DESC'));

        return array('ficheros' => $ficheros);
    }

    /**
     * Ácción que muestra el formulario para subir un nuevo fichero.
     *
     * @Template()
     */
    public function nuevoAction()
    {
        $fichero = new Fichero();
        $formulario = $this->createForm(new FicheroType(), $fichero, array(
            'action' => $this->generateUrl('private_fichero_guardar'),
            'method' => 'POST',
        ));

        return array('formulario' => $formulario->createView());
    }

    /**
     * @Template()
     */
    public function guardarAction()
    {
        $fichero = new Fichero();
        $formulario = $this->createForm(new FicheroType(), $fichero, array(
            'action' => $this->generateUrl('private_fichero_guardar'),
            'method' => 'POST',
        ));

        $formulario->handleRequest($this->getRequest());

        if($formulario->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $fichero->setUsuario($this->getUser());
            $em->persist($fichero);
            $em->flush();

            $this->get('session')->getFlashBag()->add('ok', 'Fichero subido con éxito.');

            return $this->redirect($this->generateUrl('private_fichero_listado'));

        }

        return array('formulario' => $formulario->createView());
    }
}
