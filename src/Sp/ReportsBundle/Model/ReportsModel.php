<?php
/**
 * User: Nikita
 * Date: 06.09.13
 * Time: 20:45
 */

namespace Sp\ReportsBundle\Model;

use Sp\AppBundle\Entity;
use Sp\AppBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Registry;

class ReportsModel
{
    private $reportsTitles = [
        'Performance Overview',
        'Best Time by Event',
        'Individual meet results',
        'Ranking Report',
        'Historical Progression',
        'Time Deficiency Report',
        'Age statistics ‐ Team',
        'Average Time Comparsion by Event ‐ Team',
        'Average Time Comparsion by Event ‐ State',
        'Season to Season Comparsion',
        'Swimmer to Swimmer Comparsion'
    ];

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var Repository\SwimmerRepository
     */
    private $swimmerRepository;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->swimmerRepository = $this->doctrine->getRepository('SpAppBundle:Swimmer');
    }

    /**
     * @return array
     */
    public function getReportsTitles()
    {
        return $this->reportsTitles;
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    public function getSwimmerReports(Entity\Swimmer $oSwimmer)
    {
        $aResult = [];
        $aResult['performance'] = $this->getPerformanceReport($oSwimmer);
        $aResult['bestTime'] = $this->getBestTimeReport($oSwimmer);
        $aResult['byMeet'] = $this->getByMeetReport($oSwimmer);
        $aResult['rank'] = $this->getRankReport($oSwimmer);
        $aResult['historical'] = $this->getHistoricalReport($oSwimmer);

        return $aResult;
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    private function getPerformanceReport(Entity\Swimmer $oSwimmer)
    {
        $aResult = [];
        $aPerformance = $this->swimmerRepository->getPerformanceReport($oSwimmer);
        foreach($aPerformance as $row) {
            $event = $row['distance'] . ' ' . $row['style'] . ' ' . $row['course'];
            if (!isset($aResult[$event])) {
                $aResult[$event] = [];
            }

            $aResult[$event][] = $row;
        }
        return $aResult;
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    private function getBestTimeReport(Entity\Swimmer $oSwimmer)
    {
        return $this->swimmerRepository->getBestTimeReport($oSwimmer);
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    private function getByMeetReport(Entity\Swimmer $oSwimmer)
    {
        return $this->swimmerRepository->getByMeetReport($oSwimmer);
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    private function getRankReport(Entity\Swimmer $oSwimmer)
    {
        $aResult = [];
        $aRank = $this->swimmerRepository->getRankReport($oSwimmer);

        foreach($aRank as $row) {
            $event = $row['distance'] . ' ' . $row['style'] . ' ' . $row['course'];
            if (!isset($aResult[$event])) {
                $aResult[$event] = [];
            }

            if ($row['resultsNum'] > 1) {
                $row['tile'] = round((($row['rank'] - 1) / ($row['resultsNum'] - 1)) * 100, 2);
            } else {
                $row['tile'] = null;
            }


            $aResult[$event][] = $row;
        }

        return $aResult;
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    private function getHistoricalReport(Entity\Swimmer $oSwimmer)
    {
        $aEvents = [];
        $aEventResults = $this->swimmerRepository->getHistoricalReport($oSwimmer);
        foreach($aEventResults as $row) {
            $event = $row['distance'] . ' ' . $row['style'] . ' ' . $row['course'];
            if (!isset($aEvents[$event])) {
                $aEvents[$event] = [];
            }

            $aEvents[$event][] = $row;
        }

        $report = [];
        foreach($aEvents as $event => $aEventResults) {
            $aDate = [];
            $aSwimmerSeconds = [];
            $aTempSeconds = [];

            foreach($aEventResults as $res) {
                $aDate[] = $res['date']->format('d/m/Y');
                $aSwimmerSeconds[] = $res['seconds'];
                $aTempSeconds[] = $res['seconds'] - 1;
            }

            $report[$event] = [
                'dates' => json_encode($aDate),
                'swimmerSeconds' => json_encode($aSwimmerSeconds),
                'tempSeconds' => json_encode($aTempSeconds),
            ];
        }

        return $report;
    }
}