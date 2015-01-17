<?php

namespace Amcb\CommonBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UsuarioRepository extends EntityRepository implements UserProviderInterface
{
    /**
     * Devuelve todos aquellos usuarios con email y con el rango mínimo para acceder al área privada.
     *
     * @return array Usuarios
     */
    public function getWithEmail()
    {
        $q = $this
            ->createQueryBuilder('u')
            ->where('u.email != :email')
            ->andWhere('u.email IS NOT NULL')
            ->andWhere('u.rango > 0')
            ->setParameter('email', "")
            ->getQuery();

        return $q->getResult();
    }

    public function loadUserByUsername($dni)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->where('u.dni = :dni AND u.rango > 0')
            ->setParameter('dni', $dni)
            ->getQuery();

        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active admin AcmeUserBundle:User object identified by "%s".',
                $dni
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }
}
