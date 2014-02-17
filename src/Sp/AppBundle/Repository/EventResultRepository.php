<?php
/**
 * User: nikk
 * Date: 2/12/14
 * Time: 8:39 AM
 */

namespace Sp\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Sp\AppBundle\Entity;

class EventResultRepository extends EntityRepository
{
    /**
     * @param Entity\Swimmer $oSwimmer
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function getCommonReportBillet(Entity\Swimmer $oSwimmer)
    {
        return $this
            ->createQueryBuilder('er')
            ->innerJoin('er.event', 'e')
            ->innerJoin('e.meet', 'm')
            ->innerJoin('e.eventTemplate', 'et')
            ->innerJoin('et.distance', 'd')
            ->where('er.swimmer = :swimmerId')
            ->setParameter('swimmerId', $oSwimmer->getId())
            ->orderBy('d.length');
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    public function getPerformanceReport(Entity\Swimmer $oSwimmer)
    {
        return $this
            ->getCommonReportBillet($oSwimmer)
            ->select('er as res, e, et.title as eventTitle, s.gender')
            ->innerJoin('er.swimmer', 's')
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
            ->createQueryBuilder('er')
            ->select('et.title, MIN(er.seconds) as seconds')
            ->innerJoin('er.event', 'e')
            ->innerJoin('e.eventTemplate', 'et')
            ->innerJoin('et.distance', 'd')
            ->groupBy('et.id')
            ->where('er.swimmer = :swimmerId')
            ->setParameter('swimmerId', $oSwimmer->getId())
            ->orderBy('d.length')
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
            ->getCommonReportBillet($oSwimmer)
            ->select('er as res, e, et.title as eventTitle')
            ->orderBy('m.title, d.length')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $eventIds
     *
     * @return array
     */
    public function getMaxRangByEvents($eventIds)
    {
        return $this
            ->createQueryBuilder('er')
            ->select('IDENTITY(er.event) as event, MAX(er.rank) as maxRank')
            ->groupBy('event')
            ->andWhere('IDENTITY(er.event) IN (:eventIds)')
            ->setParameter('eventIds', $eventIds)
            ->getQuery()
            ->getResult();
    }
}