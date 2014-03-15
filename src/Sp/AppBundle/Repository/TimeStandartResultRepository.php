<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 16:24
 */

namespace Sp\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Sp\AppBundle\Entity;

class TimeStandartResultRepository extends EntityRepository
{
    /**
     * @param int    $eventTemplateId
     * @param string $gender
     * @param int    $age
     *
     * @return array
     */
    public function findTimeStandartsForEvent($eventTemplateId, $gender, $age)
    {
        return $this
            ->createQueryBuilder('tsr')
            ->select('tsr.seconds, ts.title')
            ->innerJoin('SpAppBundle:TimeStandart', 'ts', 'WITH', 'tsr.timeStandart = ts.id')
            ->where('tsr.eventTemplate = :eventTemplate')
            ->andWhere('tsr.gender = :gender')
            ->andWhere('tsr.minAge <= :age')
            ->andWhere('tsr.maxAge >= :age')
            ->setParameter('eventTemplate', $eventTemplateId)
            ->setParameter('gender', $gender)
            ->setParameter('age', $age)
            ->getQuery()
            ->getResult();
    }
}