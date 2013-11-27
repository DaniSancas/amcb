<?php

namespace Amcb\CommonBundle\Entity;

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
            'SELECT c FROM CommonBundle:Concierto c '.
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
     * @param int $limit Límite de conciertos a mostrar.
     * @return Array Conciertos
     */
    public function getPasados($limit = 10)
    {
        $q = $this->getEntityManager()->createQuery(
            'SELECT c FROM CommonBundle:Concierto c '.
            'WHERE c.es_visible = :es_visible '.
            'AND c.fecha < CURRENT_DATE()'.
            'ORDER BY c.fecha DESC');
        
        $q->setParameter('es_visible', true);
        $q->setMaxResults($limit);
            
        return $q->getResult();
    }
    
}

?>
