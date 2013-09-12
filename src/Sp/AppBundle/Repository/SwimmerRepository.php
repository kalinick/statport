<?php
/**
 * User: Nikita
 * Date: 05.09.13
 * Time: 21:27
 */

namespace Sp\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Sp\AppBundle\Entity;

class SwimmerRepository extends EntityRepository
{
    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    public function getPerformanceReport(Entity\Swimmer $oSwimmer)
    {
        return $this
            ->createQueryBuilder('s')
            ->select("d.length as distance, ss.title as style, c.title as course, m.date, m.title as meet, er.seconds")
            ->addSelect('s.gender')
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
    public function getBestTimeReport(Entity\Swimmer $oSwimmer)
    {
        return $this
            ->createQueryBuilder('s')
            ->select("d.length as distance, ss.title as style, c.title as course, MIN(er.seconds) as seconds")
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
            ->select("d.length as distance, ss.title as style, c.title as course, m.date, m.title as meet, er.seconds")
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
            ->select("d.length as distance, ss.title as style, c.title as course, m.date, m.title as meet, er.rank, e.resultsNum")
            ->addSelect('s.gender')
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
            ->select("d.length as distance, ss.title as style, c.title as course, er.seconds, m.date")
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

}