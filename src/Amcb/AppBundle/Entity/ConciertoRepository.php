<?php

namespace Amcb\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class ConciertoRepository extends EntityRepository
{
    /**
     * Devuelve, de más próximo a más lejano, el listado de próximos conciertos.
     * 
     * @param int $limit Límite de conciertos a mostrar.
     * @return Array Conciertos
     */
    public function getProximos($limit = 10)
    {
        $q = $this->getEntityManager()->createQuery(
            'SELECT c FROM AppBundle:Concierto c '.
            'WHERE c.es_visible = :es_visible '.
            'AND c.fecha >= CURRENT_DATE()'.
            'ORDER BY c.fecha ASC');
        
        $q->setParameter('es_visible', true);
        $q->setMaxResults($limit);
            
        return $q->getResult();
    }
    
    /**
     * Devuelve, de más próximo a más lejano, el listado de conciertos ya pasados.
     * 
     * @param int $year Año de los conciertos a mostrar (funciona como paginación)
     * @return Array Conciertos
     */
    public function getPasados($year)
    {
        $q = $this->getEntityManager()->createQuery(
            'SELECT c FROM AppBundle:Concierto c '.
            'WHERE c.es_visible = :es_visible '.
            'AND c.fecha < CURRENT_DATE() '.
            'AND SUBSTRING(c.fecha, 1, 4) = :year '.
            'ORDER BY c.fecha DESC');
        
        $q->setParameter('es_visible', true);
        $q->setParameter('year', $year);
            
        return $q->getResult();
    }
    
    /**
     * Devuelve un array con los años en los que ha habido conciertos.
     * 
     * Se utilizará para paginar resultados del archivo de conciertos.
     * 
     * @return Array Años
     */
    public function getPeriodosPaginacion()
    {
        $q = $this->getEntityManager()->createQuery(
            'SELECT DISTINCT SUBSTRING(c.fecha, 1, 4) as year FROM AppBundle:Concierto c WHERE c.fecha < CURRENT_DATE() ORDER BY c.fecha DESC'
        );
      
        return $q->getResult();
    }
}

?>
