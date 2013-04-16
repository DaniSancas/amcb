<?php

namespace Amcb\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Miembro
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Miembro
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=50)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=10)
     */
    private $dni;

    /**
     * @var boolean
     *
     * @ORM\Column(name="es_director", type="boolean")
     */
    private $esDirector;

    /**
     * @var boolean
     *
     * @ORM\Column(name="es_admin", type="boolean")
     */
    private $esAdmin;


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
     * Set nombre
     *
     * @param string $nombre
     * @return Miembro
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
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
    
        return $this;
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
    
        return $this;
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
     * Set dni
     *
     * @param string $dni
     * @return Miembro
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    
        return $this;
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
     * Set esDirector
     *
     * @param boolean $esDirector
     * @return Miembro
     */
    public function setEsDirector($esDirector)
    {
        $this->esDirector = $esDirector;
    
        return $this;
    }

    /**
     * Get esDirector
     *
     * @return boolean 
     */
    public function getEsDirector()
    {
        return $this->esDirector;
    }

    /**
     * Set esAdmin
     *
     * @param boolean $esAdmin
     * @return Miembro
     */
    public function setEsAdmin($esAdmin)
    {
        $this->esAdmin = $esAdmin;
    
        return $this;
    }

    /**
     * Get esAdmin
     *
     * @return boolean 
     */
    public function getEsAdmin()
    {
        return $this->esAdmin;
    }
}
