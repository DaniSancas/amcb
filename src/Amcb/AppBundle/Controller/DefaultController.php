<?php

namespace Amcb\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * Acción que muestra el formulario de login para acceder al área privada.
     *
     * Si el usuario ya está logeado y dispone de los permisos mínimos, nos saltamos el login.
     *
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        $user = $this->getUser();
        if($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') && $user && $user->getRango() >= 1)
            return $this->redirect($this->generateUrl('private_fichero_listado'));

        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        );
    }
}
