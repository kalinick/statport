<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 13:38
 */

namespace Sp\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Sp\AppBundle\Entity;
use Sp\ReportsBundle\Classes\AgeInterval;

class EventRepository extends EntityRepository
{
    /**
     * @param array $aIds
     * @return array
     */
    public function countEventsMember($aIds)
    {
        if (count($aIds) == 0) {
            return array();
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

    /**
     * @param int $eventId
     * @param int $clubId
     * @param AgeInterval $ageInterval
     * @param string $gender
     * @return float
     */
    public function getAvgByEventClubAgeGender($eventId, $clubId, AgeInterval $ageInterval, $gender)
    {
        return $this
            ->createQueryBuilder('e')
            ->select('AVG(er.seconds) as middle')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.event = e.id')
            ->innerJoin('SpAppBundle:Swimmer', 's', 'WITH', 's.id = er.swimmer')
            ->where('e.id = :eventId')
            ->andWhere('s.gender = :gender')
            ->andWhere('e.club = :clubId')
            ->andWhere('s.birthday >= :minBirthday')
            ->andWhere('s.birthday <= :maxBirthday')
//            ->andWhere('er.age >= :minAge')
//            ->andWhere('er.age <= :maxAge')
            ->setParameter('eventId', $eventId)
            ->setParameter('clubId', $clubId)
            ->setParameter('gender', $gender)
            ->setParameter('minBirthday', $ageInterval->getMinBirthdayAsString())
            ->setParameter('maxBirthday', $ageInterval->getMaxBirthdayAsString())
//            ->setParameter('minAge', $ageInterval->getMinAge())
//            ->setParameter('maxAge', $ageInterval->getMaxAge())
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param int $eventId
     * @param int $lscId
     * @param AgeInterval $ageInterval
     * @param string $gender
     * @return float
     */
    public function getAvgByEventRegionAgeGender($eventId, $lscId, AgeInterval $ageInterval, $gender)
    {
        return $this
            ->createQueryBuilder('e')
            ->select('AVG(er.seconds) as middle')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.event = e.id')
            ->innerJoin('SpAppBundle:Swimmer', 's', 'WITH', 's.id = er.swimmer')
            ->where('e.id = :eventId')
            ->andWhere('s.gender = :gender')
            ->andWhere('e.lsc = :lscId')
            ->andWhere('s.birthday >= :minBirthday')
            ->andWhere('s.birthday <= :maxBirthday')
//            ->andWhere('er.age >= :minAge')
//            ->andWhere('er.age <= :maxAge')
            ->setParameter('eventId', $eventId)
            ->setParameter('lscId', $lscId)
            ->setParameter('gender', $gender)
            ->setParameter('minBirthday', $ageInterval->getMinBirthdayAsString())
            ->setParameter('maxBirthday', $ageInterval->getMaxBirthdayAsString())
//            ->setParameter('minAge', $ageInterval->getMinAge())
//            ->setParameter('maxAge', $ageInterval->getMaxAge())
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return array
     */
    public function findEvents()
    {
        return $this
            ->createQueryBuilder('e')
            ->select('d.id as distanceId, ss.id as styleId, c.id as courseId, d.length as distance')
            ->addSelect('ss.title as style, c.title as course')
            ->innerJoin('SpAppBundle:Distance', 'd', 'WITH', 'e.distance = d.id')
            ->innerJoin('SpAppBundle:SwimmingStyle', 'ss', 'WITH', 'e.style = ss.id')
            ->innerJoin('SpAppBundle:Course', 'c', 'WITH', 'e.course = c.id')
            ->groupBy('distanceId, styleId, courseId')
            ->orderBy('distanceId, styleId, courseId')
            ->getQuery()
            ->getResult();
    }
}