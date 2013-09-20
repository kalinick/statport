<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 16:22
 */


namespace Sp\AppBundle\Model;

use Sp\AppBundle\Repository;
use Sp\AppBundle\Entity;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Registry;

class TimeStandartManager
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var Repository\TimeStandartResultRepository
     */
    private $tsrRepository;

    /**
     * @var Repository\TimeStandartRepository
     */
    private $tsRepository;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->tsrRepository = $this->doctrine->getRepository('SpAppBundle:TimeStandartResult');
        $this->tsRepository = $this->doctrine->getRepository('SpAppBundle:TimeStandart');
    }

    /**
     * @param int $distanceId
     * @param int $styleId
     * @param int $courseId
     * @param string $gender
     * @param int $age
     * @return array
     */
    public function getTimeStandartsForEvent($distanceId, $styleId, $courseId, $gender, $age)
    {
        $aTemp = $this->tsrRepository->findTimeStandartsForEvent($distanceId, $styleId, $courseId, $gender, $age);

        $aResult = [];
        foreach($aTemp as $row) {
            $aResult[$row['title']] = $row['seconds'];
        }
        return $aResult;
    }

    /**
     * @return array
     */
    public function getTimeStandartTitles()
    {
        return $this->tsRepository->findTimeStandartTitles();
    }
}