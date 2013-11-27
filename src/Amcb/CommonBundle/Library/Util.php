<?php

namespace Amcb\CommonBundle\Library;

/**
 * Clase que recogerá las diferentes funciones útiles para ser utilizadas en cualquier sitio de la aplicación.
 */
class Util
{
  /**
   * Devuelve el slug de la cadena dada.
   * 
   * @param string $cadena Cadena original
   * @param char $separador Caracter de separación
   * @return string Cadena slugeada
   */
  static public function getSlug($cadena, $separador = '-')
  {
    // Código copiado de http://cubiq.org/the-perfect-php-clean-url-generator
    $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
    $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
    $slug = strtolower(trim($slug, $separador));
    $slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);
    
    return $slug;
  }
}
?>
