<?php

namespace Amcb\CommonBundle\Entity;

use Doctrine\ORM\EntityRepository;


class ConciertoRepository extends EntityRepository
{
    /**
     * Devuelve, de más próximo a más lejano, un listado de conciertos.
     * 
     * @param int $limit Límite de conciertos a mostrar.
     * @return Array Conciertos
     */
    public function findUltimos($limit = 10)
    {
        $q = $this->getEntityManager()->createQuery(
            $this->incFromEntradaWhereVisible().
            'AND c.fecha > CURRENT_DATE()'.
            'ORDER BY c.fecha ASC');
        
        $q->setParameter('es_visible', true);
        $q->setMaxResults($limit);
            
        return $q->getResult();
    }
}

?>
