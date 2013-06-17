<?php

namespace Amcb\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Concierto
 *
 * @ORM\Table(name="concierto")
 * @ORM\Entity(repositoryClass="Amcb\CommonBundle\Entity\ConciertoRepository")
 */
class Concierto
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
     * @ORM\Column(name="tipo", type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar", type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     */
    private $lugar;
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $fecha;
    
    /**
     * @var string
     *
     * @ORM\Column(name="noticia", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $noticia;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="es_visible", type="boolean", nullable=false)
     * @Assert\NotNull()
     */
    private $es_visible;

    /**
     * @var string
     *
     * @ORM\Column(name="maps", type="string", length=255, nullable=true)
     */
    private $maps;

    /**
     * @var boolean
     *
     * @ORM\Column(name="es_gratis", type="boolean", nullable=false)
     * @Assert\NotNull()
     */
    private $es_gratis;

    /**
     * @var string
     *
     * @ORM\Column(name="texto_entradas", type="text", length=1000, nullable=true)
     */
    private $entradas;

    /**
     * @var string
     *
     * @ORM\Column(name="programa", type="text", length=5000, nullable=true)
     */
    private $programa;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $direccion;
    
    /**
     * Object constructor
     * 
     */
    public function __construct()
    {
        $this->fecha = new \DateTime('next saturday 20:00');
        $this->es_visible = true;
        $this->es_gratis = true;
        $this->direccion = 'Paula Pérez Bueno';
    }
    
    /**
     * Get object name
     *
     * @return string 
     */
    public function __toString()
    {
        return ($this->getNoticia()) ? : '';
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
     * Set tipo
     *
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
    
    /**
     * Set lugar
     *
     * @param string $lugar
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    /**
     * Get lugar
     *
     * @return string 
     */
    public function getLugar()
    {
        return $this->lugar;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set noticia
     *
     * @param string $noticia
     */
    public function setNoticia($noticia)
    {
        $this->noticia = $noticia;
    }

    /**
     * Get noticia
     *
     * @return string 
     */
    public function getNoticia()
    {
        return $this->noticia;
    }
    
    /**
     * Set es_visible
     *
     * @param boolean $esVisible
     */
    public function setEsVisible($esVisible)
    {
        $this->es_visible = $esVisible;
    }

    /**
     * Get es_visible
     *
     * @return boolean 
     */
    public function getEsVisible()
    {
        return $this->es_visible;
    }

    /**
     * Set maps
     *
     * @param string $maps
     */
    public function setMaps($maps)
    {
        $this->maps = $maps;
    }

    /**
     * Get maps
     *
     * @return string 
     */
    public function getMaps()
    {
        return $this->maps;
    }

    /**
     * Set es_gratis
     *
     * @param boolean $esGratis
     */
    public function setEsGratis($esGratis)
    {
        $this->es_gratis = $esGratis;
    }

    /**
     * Get es_gratis
     *
     * @return boolean 
     */
    public function getEsGratis()
    {
        return $this->es_gratis;
    }

    /**
     * Set entradas
     *
     * @param string $entradas
     */
    public function setEntradas($entradas)
    {
        $this->entradas = $entradas;
    }

    /**
     * Get entradas
     *
     * @return string 
     */
    public function getEntradas()
    {
        return $this->entradas;
    }

    /**
     * Set programa
     *
     * @param string $programa
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;
    }

    /**
     * Get programa
     *
     * @return string 
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }
}