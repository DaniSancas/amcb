<?php

namespace Amcb\CommonBundle\Entity;

use Amcb\CommonBundle\Library\Util;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Fichero
 *
 * @ORM\Table(name="fichero")
 * @ORM\Entity(repositoryClass="Amcb\CommonBundle\Entity\FicheroRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Fichero
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="ficheros")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255, nullable=false)
     * @Assert\NotNull()
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="categoria", type="integer", nullable=false)
     * @Assert\NotNull()
     */
    private $categoria;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="fichero", type="string", length=255, nullable=false)
     */
    private $fichero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_creacion", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_modificacion", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $fechaModificacion;

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

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Set id
     *
     * @param integer $id
     * @return Fichero
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set usuario
     *
     * @param integer $usuario
     * @return Fichero
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return integer 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Fichero
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
     * Set categoria
     *
     * @param string $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * Get categoria
     *
     * @return string
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Fichero
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fichero
     *
     * @param string $fichero
     * @return Fichero
     */
    public function setFichero($fichero)
    {
        $this->fichero = $fichero;

        return $this;
    }

    /**
     * Get fichero
     *
     * @return string
     */
    public function getFichero()
    {
        return $this->fichero;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Fichero
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
    
        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime 
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
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
     * Devuelve el array de categorías, obviando el primer elemento (para filtros)
     *
     * @return array Categorías
     */
    public function getCategorias()
    {
        return Util::getCategorias(false);
    }

    /**
     * Devuelve el nombre de la categoría elegida.
     *
     * Si no tiene ninguna elegida, evitamos que se lance un error. (Posible problema durante migración)
     *
     * @return string Categoría elegida
     */
    public function getCategoriaElegida()
    {
        $cat = Util::getCategorias();
        return ($this->categoria >= 1) ? $cat[$this->categoria] : "";
    }

    //------------------------------------------------------------------------------------------------------------------
    // CALLBACK & FILE METHODS

    /**
     * Set file
     *
     * Si existe ya un fichero, guardamos su nombre.
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
            $this->fichero = 'initial';
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
     * Devuelve la ruta absoluta del fichero.
     *
     * Si tenemos un fichero guardado, devolveremos su ruta absoluta junto con el nombre completo.
     *
     * El nombre completo será el nombre del fichero almacenado con su extensión. Si el registro no es nuevo, el fichero estará precedido por $this->id
     *
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->fichero
            ? null
            : $this->getUploadRootDir().'/'.((null === $this->id) ? : $this->id."_").$this->fichero;
    }

    /**
     * Devuelve la ruta web del fichero.
     *
     * Si tenemos un fichero guardado, devolveremos su ruta relativa junto con el nombre completo.
     *
     * El nombre completo será el nombre del fichero almacenado con su extensión, precedido por $this->id
     *
     * @return null|string
     */
    public function getFicheroWeb()
    {
        return null === $this->fichero
            ? null
            : $this->getUploadDir().'/'.$this->id."_".$this->fichero;
    }

    /**
     * Devuelve el tamaño del fichero almacenado.
     *
     * Si se elije el modo "enMegaBytes" se proporcionará el texto formateado.
     *
     * De lo contrario, se mostrará el número de bytes tal cual.
     *
     * @param bool $enMegaBytes Mostrar el texto formateado a MB o en crudo
     * @return int|string
     */
    public function getFicheroSize($enMegaBytes = true)
    {
        $size = filesize($this->getUploadRootDir().'/'.$this->id."_".$this->fichero);
        return ($enMegaBytes) ? ((!$size) ? "(Desconocido) ~0MB" : round($size/(1024*1024), 2)."MB") : $size;
    }

    /**
     * Devuelve la ruta absoluta del directorio donde se suben los ficheros.
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * Devuelve la ruta relativa del directorio web donde se encontrarán los ficheros.
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads';
    }

    /**
     * Asigna a $this->fichero el nombre que será guardado en la BD.
     *
     * El nombre será slugeado para evitar caracteres raros.
     *
     * Sin embargo, el fichero será subido con el nombre slugeado, precedido de $this-id."_"
     *
     * Por ejemplo: 1_mi-fichero.rar
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if(null !== $this->getFile())
            $this->fichero = Util::getSlug(pathinfo($this->getFile()->getClientOriginalName(), PATHINFO_FILENAME)).".".$this->getFile()->getClientOriginalExtension();
    }

    /**
     * En caso de que se haya subido un fichero:
     *
     * * Comprobará si hay otro que ocupe su lugar, en caso afirmativo lo eliminará.
     * * Moverá el fichero nuevo a la ruta correspondiente y con el nombre precedido de $this->id
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
        $this->getFile()->move($this->getUploadRootDir(), $this->id.'_'.$this->fichero);

        $this->file = null;
    }

    /**
     * Guarda la ruta del fichero a eliminar.
     *
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * Si hay una ruta de fichero almacenada, elimina el fichero.
     *
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if(isset($this->temp))
            unlink($this->temp);
    }
}
