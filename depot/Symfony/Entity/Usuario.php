<?php

namespace Amcb\CommonBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Miembro
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("dni")
 * @UniqueEntity("email")
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
     * @ORM\Column(name="dni", type="string", length=10, unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $dni;
    
    /** 
     * @var string
     * 
     * @ORM\Column(name="password", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", unique=true, length=100)
     * @Assert\NotBlank(), @Assert\Email(checkMX=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="es_director", type="boolean", nullable=false)
     * @Assert\NotNull()
     */
    private $es_director;

    /**
     * @var integer
     *
     * @ORM\Column(name="rango", type="integer", nullable=false)
     */
    private $rango;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="alertas", type="boolean", nullable=false)
     * @Assert\NotNull()
     */
    private $alertas;
    
    /** 
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $salt;
    
    //--------------------------------------------------------------------------
    
    /**
     * Get object name
     * 
     * @return string
     */
    public function __toString()
    {
        return trim($this->nombre." ".$this->apellidos);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dni
     *
     * @param string $dni
     * @return Miembro
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * Get dni
     *
     * @return string 
     */
    public function getDni()
    {
        return $this->dni;
    }
    
    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Miembro
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Miembro
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Miembro
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set esDirector
     *
     * @param boolean $esDirector
     * @return Miembro
     */
    public function setEsDirector($es_director)
    {
        $this->es_director = $es_director;
    }

    /**
     * Get esDirector
     *
     * @return boolean 
     */
    public function getEsDirector()
    {
        return $this->es_director;
    }
    
    /**
     * Set rango
     *
     * @param integer $rango
     */
    public function setRango($rango)
    {
        $this->rango = $rango;
    }

    /**
     * Get rango
     *
     * @return integer 
     */
    public function getRango()
    {
        return $this->rango;
    }
    
    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Devuelve el valor que se utilizó para aleatorizar la contraseña cuando se creó el usuario.
     * 
     * @return string
     */
    function getSalt()
    {
        return $this->salt;
    }

    /**
     * Método que borra la información más sensible del usuario, como por ejemplo su contraseña.
     */
    function eraseCredentials()
    {

    }

    /**
     * Devuelve los roles del usuario dependiendo del rango que tenga.
     * 
     * @return array Roles del usuario.
     */
    function getRoles()
    {
        switch ($this->getRango()) {
            case 1:
                return array('ROLE_USUARIO');
                break;
            case 2:
                return array('ROLE_ADMIN');
                break;
            case 3:
                return array('ROLE_SUPER_ADMIN');
                break;
            default:
                return array('');
                break;
        }
    }
    
    /**
     * Devuelve el nombre único con el que se identifica al usuario.
     * 
     * @return string Nombre que identifica al usuario.
     */
    function getUsername()
    {
        return $this->getDni();
    }

    /**
     * Set alertas
     *
     * @param boolean $alertas
     * @return Usuario
     */
    public function setAlertas($alertas)
    {
        $this->alertas = $alertas;
    
        return $this;
    }

    /**
     * Get alertas
     *
     * @return boolean 
     */
    public function getAlertas()
    {
        return $this->alertas;
    }
}