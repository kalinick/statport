<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 13:38
 */

namespace Sp\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Sp\AppBundle\Entity;

class EventRepository extends EntityRepository
{
    /**
     * @param array $aIds
     * @return array
     */
    public function countEventsMember($aIds)
    {
        if (count($aIds) == 0) {
            return [];
        }

        return $this
            ->createQueryBuilder('e')
            ->select('e.id, max(er.rank) as num')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.event = e.id')
            ->groupBy('e.id')
            ->where('e.id in (:ids)')
            ->setParameter('ids', $aIds)
            ->getQuery()
            ->getResult();
    }
}