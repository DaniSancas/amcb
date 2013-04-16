<?php

namespace Amcb\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Concierto
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Concierto
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
     * @ORM\Column(name="titulo", type="string", length=100)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=50)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar", type="string", length=50)
     */
    private $lugar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="maps", type="string", length=25)
     */
    private $maps;

    /**
     * @var boolean
     *
     * @ORM\Column(name="es_gratis", type="boolean")
     */
    private $esGratis;

    /**
     * @var string
     *
     * @ORM\Column(name="texto_entradas", type="string", length=255)
     */
    private $textoEntradas;

    /**
     * @var string
     *
     * @ORM\Column(name="programa", type="text")
     */
    private $programa;

    /**
     * @var string
     *
     * @ORM\Column(name="director", type="string", length=255)
     * @ORM\ManyToOne(targetEntity="Amcb\FrontendBundle\Entity\Miembro")
     */
    private $director;


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
     * Set titulo
     *
     * @param string $titulo
     * @return Concierto
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Concierto
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
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
     * @return Concierto
     */
    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    
        return $this;
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
     * @return Concierto
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
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
     * Set maps
     *
     * @param string $maps
     * @return Concierto
     */
    public function setMaps($maps)
    {
        $this->maps = $maps;
    
        return $this;
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
     * Set esGratis
     *
     * @param boolean $esGratis
     * @return Concierto
     */
    public function setEsGratis($esGratis)
    {
        $this->esGratis = $esGratis;
    
        return $this;
    }

    /**
     * Get esGratis
     *
     * @return boolean 
     */
    public function getEsGratis()
    {
        return $this->esGratis;
    }

    /**
     * Set textoEntradas
     *
     * @param string $textoEntradas
     * @return Concierto
     */
    public function setTextoEntradas($textoEntradas)
    {
        $this->textoEntradas = $textoEntradas;
    
        return $this;
    }

    /**
     * Get textoEntradas
     *
     * @return string 
     */
    public function getTextoEntradas()
    {
        return $this->textoEntradas;
    }

    /**
     * Set programa
     *
     * @param string $programa
     * @return Concierto
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;
    
        return $this;
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
     * Set director
     *
     * @param \Amcb\FrontendBundle\Entity\Miembro $director
     * @return Concierto
     */
    public function setDirector(\Amcb\FrontendBundle\Entity\Miembro $director)
    {
        $this->director = $director;
    
        return $this;
    }

    /**
     * Get director
     *
     * @return \Amcb\FrontendBundle\Entity\Miembro Director 
     */
    public function getDirector()
    {
        return $this->director;
    }
}
