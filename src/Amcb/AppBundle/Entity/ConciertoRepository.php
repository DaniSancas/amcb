<?php

namespace Amcb\AppBundle\Entity;

use Doctrine\ORM\EntityRepository;


class ConciertoRepository extends EntityRepository
{
    /**
     * Devuelve, de más próximo a más lejano, el listado de próximos conciertos.
     * 
     * @param int $limit Límite de conciertos a mostrar.
     * @return array Concierto
     */
    public function getProximos($limit = Concierto::MAX_PROXIMOS)
    {
        $q = $this
            ->createQueryBuilder('c')
            ->where('c.es_visible = :es_visible')
            ->andWhere('c.fecha >= CURRENT_DATE()')
            ->orderBy('c.fecha');

        $q->setParameter('es_visible', true);
        $q->setMaxResults($limit);

        return $q->getQuery()->getResult();
    }
    
    /**
     * Devuelve, de más próximo a más lejano, el listado de conciertos ya pasados.
     * 
     * @param int $year Año de los conciertos a mostrar (funciona como paginación)
     * @return array Concierto
     */
    public function getPasados($year)
    {
        $q = $this
            ->createQueryBuilder('c')
            ->where('c.es_visible = :es_visible')
            ->andWhere('c.fecha < CURRENT_DATE()')
            ->andWhere('SUBSTRING(c.fecha, 1, 4) = :year')
            ->orderBy('c.fecha', 'DESC');

        $q->setParameter('es_visible', true);
        $q->setParameter('year', $year);

        return $q->getQuery()->getResult();
    }
    
    /**
     * Devuelve un array con los años en los que ha habido conciertos.
     * 
     * Se utilizará para paginar resultados del archivo de conciertos.
     * 
     * @return array int Años
     */
    public function getPeriodosPaginacion()
    {
        $q = $this
            ->createQueryBuilder('c')
            ->select('SUBSTRING(c.fecha, 1, 4) as year')
            ->where('c.es_visible = :es_visible')
            ->andWhere('c.fecha < CURRENT_DATE()')
            ->orderBy('c.fecha', 'DESC')
            ->distinct();

        $q->setParameter('es_visible', true);

        return $q->getQuery()->getResult();
    }
}

?>
