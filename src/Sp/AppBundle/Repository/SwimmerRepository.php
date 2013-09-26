<?php
/**
 * User: Nikita
 * Date: 05.09.13
 * Time: 21:27
 */

namespace Sp\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Sp\AppBundle\Entity;
use Sp\ReportsBundle\Classes\AgeInterval;

class SwimmerRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this
            ->createQueryBuilder('s')
            ->orderBy('s.lastName, s.firstName')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    public function getPerformanceReport(Entity\Swimmer $oSwimmer)
    {
        return $this
            ->createQueryBuilder('s')
            ->select('d.length as distance, ss.title as style, c.title as course, m.date, m.title as meet, er.seconds')
            ->addSelect('s.gender, l.title as lsc, cl.title as club, er.age, e.id as eventId, cl.id as clubId')
            ->addSelect('l.id as lscId')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.swimmer = s.id')
            ->innerJoin('SpAppBundle:Event', 'e', 'WITH', 'e.id = er.event')
            ->innerJoin('SpAppBundle:Meet', 'm', 'WITH', 'm.id = e.meet')
            ->innerJoin('SpAppBundle:Distance', 'd', 'WITH', 'e.distance = d.id')
            ->innerJoin('SpAppBundle:SwimmingStyle', 'ss', 'WITH', 'e.style = ss.id')
            ->innerJoin('SpAppBundle:Course', 'c', 'WITH', 'e.course = c.id')
            ->innerJoin('SpAppBundle:Lsc', 'l', 'WITH', 'e.lsc = l.id')
            ->innerJoin('SpAppBundle:Club', 'cl', 'WITH', 'e.club = cl.id')
            ->where('s.id = :swimmer_id')
            ->setParameter('swimmer_id', $oSwimmer->getId())
            ->orderBy('distance, style, course, m.date')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    public function getBestTimeReport(Entity\Swimmer $oSwimmer)
    {
        return $this
            ->createQueryBuilder('s')
            ->select('d.length as distance, ss.title as style, c.title as course, MIN(er.seconds) as seconds')
            ->addSelect('d.id as distanceId, ss.id as styleId, c.id as courseId, IDENTITY(e.club) as clubId')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.swimmer = s.id')
            ->innerJoin('SpAppBundle:Event', 'e', 'WITH', 'e.id = er.event')
            ->innerJoin('SpAppBundle:Distance', 'd', 'WITH', 'e.distance = d.id')
            ->innerJoin('SpAppBundle:SwimmingStyle', 'ss', 'WITH', 'e.style = ss.id')
            ->innerJoin('SpAppBundle:Course', 'c', 'WITH', 'e.course = c.id')
            ->groupBy('d.length, ss.title, c.title')
            ->where('s.id = :swimmer_id')
            ->setParameter('swimmer_id', $oSwimmer->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    public function getByMeetReport(Entity\Swimmer $oSwimmer)
    {
        return $this
            ->createQueryBuilder('s')
            ->select('d.length as distance, ss.title as style, c.title as course, m.date, m.title as meet, er.seconds')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.swimmer = s.id')
            ->innerJoin('SpAppBundle:Event', 'e', 'WITH', 'e.id = er.event')
            ->innerJoin('SpAppBundle:Meet', 'm', 'WITH', 'm.id = e.meet')
            ->innerJoin('SpAppBundle:Distance', 'd', 'WITH', 'e.distance = d.id')
            ->innerJoin('SpAppBundle:SwimmingStyle', 'ss', 'WITH', 'e.style = ss.id')
            ->innerJoin('SpAppBundle:Course', 'c', 'WITH', 'e.course = c.id')
            ->where('s.id = :swimmer_id')
            ->setParameter('swimmer_id', $oSwimmer->getId())
            ->orderBy('m.date, distance, style, course')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    public function getRankReport(Entity\Swimmer $oSwimmer)
    {
        return $this
            ->createQueryBuilder('s')
            ->select('d.length as distance, ss.title as style, c.title as course, m.date, m.title as meet, er.rank')
            ->addSelect('s.gender, e.id')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.swimmer = s.id')
            ->innerJoin('SpAppBundle:Event', 'e', 'WITH', 'e.id = er.event')
            ->innerJoin('SpAppBundle:Meet', 'm', 'WITH', 'm.id = e.meet')
            ->innerJoin('SpAppBundle:Distance', 'd', 'WITH', 'e.distance = d.id')
            ->innerJoin('SpAppBundle:SwimmingStyle', 'ss', 'WITH', 'e.style = ss.id')
            ->innerJoin('SpAppBundle:Course', 'c', 'WITH', 'e.course = c.id')
            ->where('s.id = :swimmer_id')
            ->setParameter('swimmer_id', $oSwimmer->getId())
            ->orderBy('distance, style, course, m.date')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    public function getHistoricalReport(Entity\Swimmer $oSwimmer)
    {
        return $this
            ->createQueryBuilder('s')
            ->select('d.length as distance, ss.title as style, c.title as course, er.seconds, m.date')
            ->addSelect('d.id as distanceId, ss.id as styleId, c.id as courseId, s.birthday, s.gender')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.swimmer = s.id')
            ->innerJoin('SpAppBundle:Event', 'e', 'WITH', 'e.id = er.event')
            ->innerJoin('SpAppBundle:Meet', 'm', 'WITH', 'm.id = e.meet')
            ->innerJoin('SpAppBundle:Distance', 'd', 'WITH', 'e.distance = d.id')
            ->innerJoin('SpAppBundle:SwimmingStyle', 'ss', 'WITH', 'e.style = ss.id')
            ->innerJoin('SpAppBundle:Course', 'c', 'WITH', 'e.course = c.id')
            ->where('s.id = :swimmer_id')
            ->setParameter('swimmer_id', $oSwimmer->getId())
            ->orderBy('distance, style, course, m.date')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param AgeInterval $ageInterval
     * @param string $gender
     * @param int $distanceId
     * @param int $styleId
     * @param int $courseId
     * @param int $clubId
     * @return array
     */
    public function getMinAvgByClub(AgeInterval $ageInterval, $gender, $distanceId, $styleId, $courseId, $clubId)
    {
        return $this
            ->createQueryBuilder('s')
            ->select('MIN(er.seconds) as best, AVG(er.seconds) as middle')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.swimmer = s.id')
            ->innerJoin('SpAppBundle:Event', 'e', 'WITH', 'e.id = er.event')
            ->andWhere('s.gender = :gender')
            ->andWhere('s.birthday >= :minBirthday')
            ->andWhere('s.birthday <= :maxBirthday')
//            ->andWhere('er.age >= :minAge')
//            ->andWhere('er.age <= :maxAge')
            ->andWhere('e.distance = :distance')
            ->andWhere('e.style = :style')
            ->andWhere('e.course = :course')
            ->andWhere('e.club = :club')
            ->setParameter('gender', $gender)
            ->setParameter('minBirthday', $ageInterval->getMinBirthdayAsString())
            ->setParameter('maxBirthday', $ageInterval->getMaxBirthdayAsString())
            ->setParameter('distance', $distanceId)
            ->setParameter('style', $styleId)
            ->setParameter('course', $courseId)
            ->setParameter('club', $clubId)
//            ->setParameter('minAge', $ageInterval->getMinAge())
//            ->setParameter('maxAge', $ageInterval->getMaxAge())
            ->getQuery()
            ->getSingleResult();
    }
}