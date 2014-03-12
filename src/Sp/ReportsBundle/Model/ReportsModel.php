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
//        'Season to Season Comparsion',
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
     * @var Repository\EventResultRepository
     */
    private $eventResultRepository;

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
        $this->eventResultRepository = $this->doctrine->getRepository('SpAppBundle:EventResult');
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
        $reports = array();
        $reports['performance'] = $this->getPerformanceReport($oSwimmer);
        $reports['bestTime'] = $this->getBestTimeReport($oSwimmer);
        $reports['byMeet'] = $this->getByMeetReport($oSwimmer);
        $reports['rank'] = $this->getRankReport($reports['performance']);
//        $reports['historical'] = $this->getHistoricalReport($oSwimmer);
//        $reports['timeDeficiency'] = $this->getTimeDeficiencyReport($oSwimmer);
//        $reports['withinTeam'] = $this->getWithinTeamReport($oSwimmer);
//        $reports['withinTeamGraphic'] = $this->getWithinTeamGraphicReport($oSwimmer, $reports['performance']);
//        $reports['withinRegionGraphic'] = $this->getWithinRegionGraphicReport($oSwimmer, $reports['performance']);

        return $reports;
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    private function getPerformanceReport(Entity\Swimmer $oSwimmer)
    {
        $performance = array();
        $results = $this->eventResultRepository->getPerformanceReport($oSwimmer);
        foreach($results as $result) {
            $event = $result->getEvent()->getEventTemplate()->getTitle();
            if (!isset($performance[$event])) {
                $performance[$event] = array();
            }

            $performance[$event][] = $result;
        }
        return $performance;
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    private function getBestTimeReport(Entity\Swimmer $oSwimmer)
    {
        return $this->eventResultRepository->getBestTimeReport($oSwimmer);
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    private function getByMeetReport(Entity\Swimmer $oSwimmer)
    {
        return $this->eventResultRepository->getByMeetReport($oSwimmer);
    }

    /**
     * @param array $performanceReport
     *
     * @return array
     */
    private function getRankReport(array $performanceReport)
    {
        $eventIds = array();
        foreach($performanceReport as $eventResults) {
            foreach($eventResults as $eventResult) {
                $eventIds[] = $eventResult->getEvent()->getId();
            }
        }

        $maxRangListRaw = $this->eventResultRepository->getMaxRangByEvents($eventIds);
        $maxRangList = array();
        foreach($maxRangListRaw as $row) {
            $maxRangList[$row['event']] = $row['maxRank'];
        }

        foreach($performanceReport as $k1 => $eventResults) {
            foreach($eventResults as $k2 => $eventResult) {
                $performanceReport[$k1][$k2]->maxRang = (int) $maxRangList[$eventResult->getEvent()->getId()];
                if ($performanceReport[$k1][$k2]->maxRang > 1) {
                    $performanceReport[$k1][$k2]->tile =
                        round((($eventResult->getRank() - 1) / ($performanceReport[$k1][$k2]->maxRang - 1)) * 100, 2);
                }
            }
        }

        return $performanceReport;
    }

    /**
     * @param array $performanceReport
     *
     * @return array
     */
    private function getHistoricalReport(array $performanceReport)
    {
        $aEvents = array();
        $aEventResults = $this->swimmerRepository->getHistoricalReport($oSwimmer);
        foreach($aEventResults as $row) {
            $event = $row['distance'] . ' ' . $row['style'] . ' ' . $row['course'];
            if (!isset($aEvents[$event])) {
                $aEvents[$event] = array();
            }

            $aEvents[$event][] = $row;
        }

        $aTimeStandartTitles = $this->getTimeStandartManager()->getTimeStandartTitles();

        $report = array();
        foreach($aEvents as $event => $aEventResults) {
            $aDate = array();
            $aSwimmerSeconds = array();
            $aTimeStandartSeconds = array();
            foreach($aTimeStandartTitles as $row) {
                $aTimeStandartSeconds[$row['title']] = array();
            }

            foreach($aEventResults as $res) {
                $aDate[] = $res['date']->format('d/m/Y');
                $aSwimmerSeconds[] = $res['seconds'];
                //$age = $this->getHelperModel()->getAge($res['birthday'], $res['date']);
                $age = $this->getHelperModel()->getAge($res['birthday']);

                $tempTimeStandart = $this->getTimeStandartManager()->getTimeStandartsForEvent(
                    $res['distanceId'], $res['styleId'], $res['courseId'], $res['gender'], $age);

                foreach($aTimeStandartSeconds as $title => $val) {
                    $aTimeStandartSeconds[$title][] = (isset($tempTimeStandart[$title])) ? $tempTimeStandart[$title] : null;
                }
            }

            $report[$event] = array(
                'dates' => json_encode($aDate),
                'swimmerSeconds' => json_encode($aSwimmerSeconds),
                'timeStandartSeconds' => json_encode($aTimeStandartSeconds),
            );
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

    /**
     * @param Entity\Swimmer $oSwimmer
     * @return array
     */
    public function getWithinTeamReport(Entity\Swimmer $oSwimmer)
    {
        $aBestTime = $this->swimmerRepository->getBestTimeReport($oSwimmer);

        foreach($aBestTime as &$res) {
            $age = $this->getHelperModel()->getAge($oSwimmer->getBirthday());
            $ageInterval = $this->getHelperModel()->getAgeInterval($age);

            $minAvg = $this->swimmerRepository->getMinAvgByClub(
                $ageInterval,
                $oSwimmer->getGender(),
                $res['distanceId'],
                $res['styleId'],
                $res['courseId'],
                $res['clubId']
            );
            $res['best'] = $minAvg['best'];
            $res['avg'] = ($minAvg['middle'] === null) ? null : round($minAvg['middle'], 2);
        }

        return $aBestTime;
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @param array $performance
     * @return array
     */
    public function getWithinTeamGraphicReport(Entity\Swimmer $oSwimmer, $performance)
    {
        $aResult = array();
        foreach($performance as $style => $aEvent) {
            $aResult[$style] = array('meet' => array(), 'my' => array(), 'avg' => array());
            foreach($aEvent as $event) {
                $age = $this->getHelperModel()->getAge($oSwimmer->getBirthday());
                $ageInterval = $this->getHelperModel()->getAgeInterval($age);
                $avg = $this->eventRepository->getAvgByEventClubAgeGender($event['eventId'], $event['clubId'], $ageInterval, $oSwimmer->getGender());

                $aResult[$style]['meet'][] = $event['meet'];
                $aResult[$style]['my'][] = $event['seconds'];
                $aResult[$style]['avg'][] = (float) round($avg, 2);
            }

            $aResult[$style]['meet'] = json_encode($aResult[$style]['meet']);
            $aResult[$style]['my'] = json_encode($aResult[$style]['my']);
            $aResult[$style]['avg'] = json_encode($aResult[$style]['avg']);
        }

        return $aResult;
    }

    /**
     * @param Entity\Swimmer $oSwimmer
     * @param array $performance
     * @return array
     */
    public function getWithinRegionGraphicReport(Entity\Swimmer $oSwimmer, $performance)
    {
        $aResult = array();
        foreach($performance as $style => $aEvent) {
            $aResult[$style] = array('meet' => array(), 'my' => array(), 'avg' => array());
            foreach($aEvent as $event) {
                $age = $this->getHelperModel()->getAge($oSwimmer->getBirthday());
                $ageInterval = $this->getHelperModel()->getAgeInterval($age);
                $avg = $this->eventRepository->getAvgByEventRegionAgeGender($event['eventId'], $event['lscId'], $ageInterval, $oSwimmer->getGender());

                $aResult[$style]['meet'][] = $event['meet'];
                $aResult[$style]['my'][] = $event['seconds'];
                $aResult[$style]['avg'][] = (float) round($avg, 2);
            }

            $aResult[$style]['meet'] = json_encode($aResult[$style]['meet']);
            $aResult[$style]['my'] = json_encode($aResult[$style]['my']);
            $aResult[$style]['avg'] = json_encode($aResult[$style]['avg']);
        }

        return $aResult;
    }

    /**
     * @param $meId
     * @param $swimmerId
     * @param $event
     * @return array
     */
    public function getSwimmerToSwimmerReport($meId, $swimmerId, $event)
    {
        $comparison = $this->swimmerRepository->getSwimmerToSwimmerReport($meId, $swimmerId, $event);

        $aTemp = array();
        foreach($comparison as $row) {
            if (!isset($aTemp[$row['meet']])) {
                $aTemp[$row['meet']] = array();
            }

            if ($row['id'] == $meId) {
                $aTemp[$row['meet']]['me'] = $row['seconds'];
            } else {
                $aTemp[$row['meet']]['swimmer'] = $row['seconds'];
            }
        }

        $aResult = array();
        $aResult['meet'] = array_keys($aTemp);
        $aResult['me'] = array();
        $aResult['swimmer'] = array();
        foreach($aResult['meet'] as $meet) {
            $aResult['me'][] = (isset($aTemp[$meet]['me'])) ? $aTemp[$meet]['me'] : null;
            $aResult['swimmer'][] = (isset($aTemp[$meet]['swimmer'])) ? $aTemp[$meet]['swimmer'] : null;
        }

        return $aResult;
    }
}