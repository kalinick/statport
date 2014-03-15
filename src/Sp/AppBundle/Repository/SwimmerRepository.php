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
     * @param int $eventTemplateId
     * @param int $clubId
     * @return array
     */
    public function getMinAvgByClub(AgeInterval $ageInterval, $gender, $eventTemplateId, $clubId)
    {
        return $this
            ->createQueryBuilder('s')
            ->select('MIN(er.seconds) as best, AVG(er.seconds) as middle')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.swimmer = s.id')
            ->innerJoin('SpAppBundle:Event', 'e', 'WITH', 'e.id = er.event')
            ->andWhere('s.gender = :gender')
//            ->andWhere('s.birthday >= :minBirthday')
//            ->andWhere('s.birthday <= :maxBirthday')
//            ->andWhere('er.age >= :minAge')
//            ->andWhere('er.age <= :maxAge')
            ->andWhere('e.eventTemplate = :eventTemplate')
            ->andWhere('er.club = :club')
            ->setParameter('gender', $gender)
//            ->setParameter('minBirthday', $ageInterval->getMinBirthdayAsString())
//            ->setParameter('maxBirthday', $ageInterval->getMaxBirthdayAsString())
            ->setParameter('eventTemplate', $eventTemplateId)
            ->setParameter('club', $clubId)
//            ->setParameter('minAge', $ageInterval->getMinAge())
//            ->setParameter('maxAge', $ageInterval->getMaxAge())
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @param $meId
     * @param $swimmerId
     * @param $event
     * @return array
     */
    public function getSwimmerToSwimmerReport($meId, $swimmerId, $event)
    {
        $event = json_decode($event, true);

        return $this
            ->createQueryBuilder('s')
            ->select('s.id, m.title as meet, er.seconds')
            ->innerJoin('SpAppBundle:EventResult', 'er', 'WITH', 'er.swimmer = s.id')
            ->innerJoin('SpAppBundle:Event', 'e', 'WITH', 'e.id = er.event')
            ->innerJoin('SpAppBundle:Meet', 'm', 'WITH', 'm.id = e.meet')
            ->innerJoin('SpAppBundle:Distance', 'd', 'WITH', 'e.distance = d.id')
            ->innerJoin('SpAppBundle:SwimmingStyle', 'ss', 'WITH', 'e.style = ss.id')
            ->innerJoin('SpAppBundle:Course', 'c', 'WITH', 'e.course = c.id')
            ->where('s.id IN (:id)')
            ->andWhere('e.distance = :distance')
            ->andWhere('e.style = :style')
            ->andWhere('e.course = :course')
            ->setParameter('id', array($swimmerId, $meId))
            ->setParameter('distance', $event['distanceId'])
            ->setParameter('style', $event['styleId'])
            ->setParameter('course', $event['courseId'])
            ->orderBy('m.date')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $firstName
     * @param string $lastName
     *
     * @return Entity\Swimmer
     */
    public function findByFirstLastName($firstName, $lastName)
    {
        return $this
            ->createQueryBuilder('s')
            ->where('s.firstName = :firstName')->setParameter('firstName', $firstName)
            ->andWhere('s.lastName = :lastName')->setParameter('lastName', $lastName)
            ->getQuery()
            ->getOneOrNullResult();
    }
}