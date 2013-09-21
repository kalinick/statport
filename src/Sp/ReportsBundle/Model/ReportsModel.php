<?php
/**
 * User: Nikita
 * Date: 06.09.13
 * Time: 20:45
 */

namespace Sp\ReportsBundle\Model;

use Sp\AppBundle\Entity;
use Sp\AppBundle\Model\TimeStandartManager;
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

    /**
     * @var Repository\EventRepository
     */
    private $eventRepository;

    /**
     * @var TimeStandartManager
     */
    private $timeStandartManager;

    /**
     * @var HelperModel
     */
    private $helperModel;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->swimmerRepository = $this->doctrine->getRepository('SpAppBundle:Swimmer');
        $this->eventRepository = $this->doctrine->getRepository('SpAppBundle:Event');
    }

    /**
     * @param TimeStandartManager $timeStandartManager
     */
    public function setTimeStandartManager($timeStandartManager)
    {
        $this->timeStandartManager = $timeStandartManager;
    }

    /**
     * @return TimeStandartManager
     */
    public function getTimeStandartManager()
    {
        return $this->timeStandartManager;
    }

    /**
     * @param HelperModel $helperModel
     */
    public function setHelperModel($helperModel)
    {
        $this->helperModel = $helperModel;
    }

    /**
     * @return HelperModel
     */
    public function getHelperModel()
    {
        return $this->helperModel;
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
        $aResult['timeDeficiency'] = $this->getTimeDeficiencyReport($oSwimmer);

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

        $aIds = [];
        foreach($aRank as $row) {
            $aIds[] = $row['id'];
        }
        $aTemp = $this->eventRepository->countEventsMember($aIds);
        $aEventMemberNum = [];
        foreach($aTemp as $row) {
            $aEventMemberNum[$row['id']] = $row['num'];
        }

        foreach($aRank as $row) {
            $row['resultsNum'] = $aEventMemberNum[$row['id']];
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

        $aTimeStandartTitles = $this->getTimeStandartManager()->getTimeStandartTitles();

        $report = [];
        foreach($aEvents as $event => $aEventResults) {
            $aDate = [];
            $aSwimmerSeconds = [];
            $aTimeStandartSeconds = [];
            foreach($aTimeStandartTitles as $row) {
                $aTimeStandartSeconds[$row['title']] = [];
            }

            foreach($aEventResults as $res) {
                $aDate[] = $res['date']->format('d/m/Y');
                $aSwimmerSeconds[] = $res['seconds'];
                $age = $this->getHelperModel()->getAge($res['birthday'], $res['date']);

                $tempTimeStandart = $this->getTimeStandartManager()->getTimeStandartsForEvent(
                    $res['distanceId'], $res['styleId'], $res['courseId'], $res['gender'], $age);

                foreach($aTimeStandartSeconds as $title => $val) {
                    $aTimeStandartSeconds[$title][] = (isset($tempTimeStandart[$title])) ? $tempTimeStandart[$title] : null;
                }
            }

            $report[$event] = [
                'dates' => json_encode($aDate),
                'swimmerSeconds' => json_encode($aSwimmerSeconds),
                'timeStandartSeconds' => json_encode($aTimeStandartSeconds),
            ];
        }

        return $report;
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    public function getTimeDeficiencyReport(Entity\Swimmer $oSwimmer)
    {
        $aBestTime = $this->swimmerRepository->getBestTimeReport($oSwimmer);

        $age = $this->getHelperModel()->getAge($oSwimmer->getBirthday());
        foreach($aBestTime as &$res) {
            $aTimeStandart = $this->getTimeStandartManager()->getTimeStandartsForEvent(
                $res['distanceId'], $res['styleId'], $res['courseId'], $oSwimmer->getGender(), $age);

            if(empty($aTimeStandart)) {
                $res['achievedTs'] = null;
                $res['nextTs'] = null;
                $res['gap'] = null;
                continue;
            }

            $achieved = null;
            foreach($aTimeStandart as $key => $ts) {
                if ($res['seconds'] > $ts) {
                    break;
                }
                $achieved = $key;
            }

            if ($achieved == null) {
                $res['achievedTs'] = null;
                $nextTsValue = reset($aTimeStandart);
                $nextTs = key($aTimeStandart);
                $res['nextTs'] = $nextTs;
                $res['gap'] = $nextTsValue - $res['seconds'];
            } else {
                $res['achievedTs'] = $achieved;

                if ($res['seconds'] > $ts) {
                    $res['nextTs'] = $key;
                    $res['gap'] = $res['seconds'] - $aTimeStandart[$key];
                } else {
                    $res['nextTs'] = null;
                    $res['gap'] = null;
                }
            }
        }

        return $aBestTime;
    }
}