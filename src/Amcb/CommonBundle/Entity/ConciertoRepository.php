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
            $this->incFromConciertoWhereVisible().
            'AND c.fecha > CURRENT_DATE()'.
            'ORDER BY c.fecha ASC');
        
        $q->setParameter('es_visible', true);
        $q->setMaxResults($limit);
            
        return $q->getResult();
    }
    
    
    
    //--------------------------------------------------------------------------
    
    /**
     * Incluye el <code>SELECT FROM Concierto WHERE Visible</code> de la DQL.
     * 
     * @return string
     */
    private function incFromConciertoWhereVisible()
    {
        return $this->incFromConcierto().$this->incWhereVisible();
    }
    
    /**
     * Incluye el <code>SELECT FROM Concierto</code> de la DQL.
     * 
     * @return string
     */
    private function incFromConcierto()
    {
        return 'SELECT c FROM CommonBundle:Concierto c ';
    }
    
    /**
     * Incluye el <code>WHERE Visible</code> de la DQL
     * 
     * @return string
     */
    private function incWhereVisible()
    {
        return 'WHERE c.es_visible = :es_visible ';
    }
}

?>
