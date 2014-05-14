<?php

namespace Amcb\CommonBundle\Library;
use Symfony\Component\HttpFoundation\Request;

/**
 * Clase que recogerá las diferentes funciones útiles para ser utilizadas en cualquier sitio de la aplicación.
 */
class Util
{
    /**
     * Listado de categorías necesarias para la clasificación de ficheros.
     *
     * @var array
     */
    static private $categorias = array(
        0 => "--",
        1 => "Partituras",
        2 => "Documentos técnicos",
        3 => "Nuestra asociación",
        4 => "Archivos de audio",
        9 => "Otros"
    );

    /**
     * Devuelve el slug de la cadena dada.
     *
     * @param string $cadena Cadena original
     * @param string $separador Caracter de separación
     * @return mixed|string Cadena slugeada
     */
    static public function getSlug($cadena, $separador = '-')
    {
        setlocale(LC_CTYPE, 'es_ES');
        // Código copiado de http://cubiq.org/the-perfect-php-clean-url-generator
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
        $slug = strtolower(trim($slug, $separador));
        $slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);

        return $slug;
    }

    /**
     * Devuelve el nombre del Bundle contenido en $request
     *
     * @param Request $request
     * @return null
     */
    static public function getBundle(Request $request)
    {
        if(null === $request)
            return null;

        $pattern = "#([a-zA-Z]*)Bundle#";
        $matches = array();
        preg_match($pattern, $request->get('_controller'), $matches);

        return (count($matches)) ? $matches[0] : null;
    }

    /**
     * Devuelve el nombre del Controller contenido en $request
     *
     * @param Request $request
     * @return null
     */
    static public function getController(Request $request)
    {
        if(null === $request)
            return null;

        $pattern = "#Controller\\\([a-zA-Z]*)Controller#";
        $matches = array();
        preg_match($pattern, $request->get('_controller'), $matches);

        return (count($matches)) ? $matches[1] : null;
    }

    /**
     * Devuelve el nombre de la Action contenida en $request
     *
     * @param Request $request
     * @return null
     */
    public function getActionName(Request $request)
    {
        if(null === $request)
            return null;

        $pattern = "#::([a-zA-Z]*)Action#";
        $matches = array();
        preg_match($pattern, $request->get('_controller'), $matches);

        return (count($matches)) ? $matches[1] : null;
    }

    /**
     * Devuelve el array de categorías.
     *
     * Se eliminará el primer elemento (para filtros) si así se requiere.
     *
     * @param bool $filtro
     * @return array Categorías
     */
    static public function getCategorias($filtro = false)
    {
        if(!$filtro)
        {
            $catSinFiltro = self::$categorias;
            unset($catSinFiltro[0]);

            return $catSinFiltro;
        }else
            return self::$categorias;
    }
}
?>
