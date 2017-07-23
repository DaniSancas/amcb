<?php

namespace Amcb\AppBundle\Entity;

use Amcb\AppBundle\Library\Util;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Concierto
 *
 * @ORM\Table(name="concierto")
 * @ORM\Entity(repositoryClass="Amcb\AppBundle\Entity\ConciertoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Concierto
{
    /**
     * Límite máximo por defecto a la hora de mostrar resultados de próximos conciertos.
     */
    const MAX_PROXIMOS = 20;

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
     * @ORM\Column(name="tipo", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="lugar", type="string", length=100, nullable=false)
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
     * @var string
     *
     * @ORM\Column(name="cartel", type="string", length=255, nullable=true)
     */
    private $cartel;

    /**
     * @var string
     */
    private $temp;

    /**
     * @var string
     *
     * @Assert\File(maxSize="12582912")
     */
    private $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $fechaModificacion;
    
    /**
     * Object constructor
     * 
     */
    public function __construct()
    {
        $this->fecha = new \DateTime('next saturday 20:00');
        $this->tipo  = "Concierto";
        $this->es_visible = true;
        $this->es_gratis = false;
        $this->direccion = 'Daniel Garay';
    }
    
    /**
     * Get object name
     *
     * @return string 
     */
    public function __toString()
    {
        return ($this->getNoticia()) ? : $this->getTipo();
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
    
    /**
     * Set cartel
     *
     * @param string $cartel
     */
    public function setCartel($cartel)
    {
        $this->cartel = $cartel;
    }

    /**
     * Get cartel
     *
     * @return string
     */
    public function getCartel()
    {
        return $this->cartel;
    }

    /**
     * Set file
     *
     * Si existe ya un cartel, guardamos su nombre.
     *
     * Al guardar su nombre podremos eliminarlo más tarde si procede.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        if(is_file($this->getAbsolutePath()))
        {
            // store the old name to delete after the update
            $this->temp = $this->getAbsolutePath();
        } else {
            $this->cartel = 'initial';
        }
    }

    /**
     * Get file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     * @return Fichero
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    /**
     * Devuelve la ruta absoluta del cartel.
     *
     * Si tenemos un cartel guardado, devolveremos su ruta absoluta junto con el nombre completo.
     *
     * El nombre completo será el nombre del cartel almacenado con su extensión. Si el registro no es nuevo, el cartel estará precedido por $this->id
     *
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->cartel
            ? null
            : $this->getUploadRootDir().'/'.((null === $this->id) ? : $this->id."_").$this->cartel;
    }

    /**
     * Devuelve la ruta web del cartel.
     *
     * Si tenemos un cartel guardado, devolveremos su ruta relativa junto con el nombre completo.
     *
     * El nombre completo será el nombre del cartel almacenado con su extensión, precedido por $this->id
     *
     * @return null|string
     */
    public function getCartelWeb()
    {
        return null === $this->cartel
            ? null
            : $this->getUploadDir().'/'.$this->id."_".$this->cartel;
    }

    /**
     * Devuelve la ruta absoluta del directorio donde se suben los cartels.
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Devuelve la ruta relativa del directorio web donde se encontrarán los carteles.
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'carteles';
    }

    /**
     * Asigna a $this->cartel el nombre que será guardado en la BD.
     *
     * El nombre será slugeado para evitar caracteres raros.
     *
     * Sin embargo, el cartel será subido con el nombre slugeado, precedido de $this-id."_"
     *
     * Por ejemplo: 1_1_2_203.jpg
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if(null !== $this->getFile())
            $this->cartel = "cartel_".Util::getSlug(pathinfo($this->getFecha()->format("d-m-Y"), PATHINFO_FILENAME)).".".$this->getFile()->getClientOriginalExtension();
    }

    /**
     * En caso de que se haya subido un cartel:
     *
     * * Comprobará si hay otro que ocupe su lugar, en caso afirmativo lo eliminará.
     * * Moverá el cartel nuevo a la ruta correspondiente y con el nombre precedido de $this->id
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if(null === $this->getFile())
        {
            return;
        }

        // check if we have an old file
        if(isset($this->temp)){
            // delete the old file
            unlink($this->temp);
            // clear the temp file path
            $this->temp = null;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->id.'_'.$this->cartel);

        $this->file = null;
    }

    /**
     * Guarda la ruta del cartel a eliminar.
     *
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * Si hay una ruta de cartel almacenada, elimina el cartel.
     *
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if(isset($this->temp))
            unlink($this->temp);
    }
}
