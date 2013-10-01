<?php
/**
 * User: Nikita
 * Date: 26.09.13
 * Time: 22:38
 */

namespace Sp\AppBundle\Model;

use Sp\AppBundle\Repository;
use Sp\AppBundle\Entity;

use Doctrine\Bundle\DoctrineBundle\Registry;

class EventManager
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var Repository\EventRepository
     */
    private $repository;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $this->doctrine->getRepository('SpAppBundle:Event');
    }

    /**
     * @return array
     */
    public function findEvents()
    {
        $aEvents = $this->repository->findEvents();

        $aResult = [];
        foreach($aEvents as $event) {
            $aResult[] = [
                'key' => json_encode([
                    'distanceId' => $event['distanceId'],
                    'styleId' => $event['styleId'],
                    'courseId' => $event['courseId'],
                ]),
                'value' => $event['distance'] . ' ' . $event['style'] . ' ' . $event['course']
            ];
        }

        return $aResult;
    }
}