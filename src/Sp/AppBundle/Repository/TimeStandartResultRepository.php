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
     * @param int $distanceId
     * @param int $styleId
     * @param int $courseId
     * @param string $gender
     * @param int $age
     * @return array
     */
    public function findTimeStandartsForEvent($distanceId, $styleId, $courseId, $gender, $age)
    {
        return $this
            ->createQueryBuilder('tsr')
            ->select('tsr.seconds, ts.title')
            ->innerJoin('SpAppBundle:TimeStandart', 'ts', 'WITH', 'tsr.timeStandart = ts.id')
            ->where('tsr.distance = :distance')
            ->andWhere('tsr.style = :style')
            ->andWhere('tsr.course = :course')
            ->andWhere('tsr.gender = :gender')
            ->andWhere('tsr.minAge <= :age')
            ->andWhere('tsr.maxAge >= :age')
            ->setParameter('distance', $distanceId)
            ->setParameter('style', $styleId)
            ->setParameter('course', $courseId)
            ->setParameter('gender', $gender)
            ->setParameter('age', $age)
            ->getQuery()
            ->getResult();
    }
}