<?php

namespace Amcb\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("dni")
 * @UniqueEntity("email")
 * @ORM\Entity(repositoryClass="Amcb\CommonBundle\Entity\UsuarioRepository")
 */
class Usuario implements UserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="usuario", type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     */
    private $usuario;
    
    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=10, unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", unique=true, length=100, nullable=true)
     * @Assert\Email(checkMX=true)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="rango", type="integer", nullable=false)
     * @Assert\NotNull()
     */
    private $rango;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Fichero", mappedBy="usuario")
     */
    private $ficheros;

    //--------------------------------------------------------------------------

    /**
     * Constructor de la clase
     */
    function __construct()
    {
        $this->rango = 0;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return ($this->usuario) ? : "";
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param string $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param integer $rango
     */
    public function setRango($rango)
    {
        $this->rango = $rango;
    }

    /**
     * @return integer
     */
    public function getRango()
    {
        return $this->rango;
    }

    /**
     * Devuelve los roles del Usuario dependiendo de qué rango tenga.
     *
     * @return array|\Symfony\Component\Security\Core\Role\Role[]
     */
    public function getRoles()
    {
        switch ($this->rango)
        {
            case 1:
                $role = 'ROLE_USUARIO';
                break;
            case 2:
                $role = 'ROLE_ADMIN';
                break;
            case 3:
                $role = 'ROLE_SUPER_ADMIN';
                break;
            default:
                $role = 'ROLE_BLOCKED';
                break;
        }
        return array($role);
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        // Empty...
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // Empty...
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->dni;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // Empty...
    }

    /**
     * Add ficheros
     *
     * @param \Amcb\CommonBundle\Entity\Fichero $ficheros
     * @return Usuario
     */
    public function addFichero(Fichero $ficheros)
    {
        $this->ficheros[] = $ficheros;
    
        return $this;
    }

    /**
     * Remove ficheros
     *
     * @param \Amcb\CommonBundle\Entity\Fichero $ficheros
     */
    public function removeFichero(Fichero $ficheros)
    {
        $this->ficheros->removeElement($ficheros);
    }

    /**
     * Get ficheros
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFicheros()
    {
        return $this->ficheros;
    }
}