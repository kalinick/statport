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

    /**
     * @var Entity\Event[]
     */
    private $events;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->repository = $this->doctrine->getRepository('SpAppBundle:Event');
    }

    /**
     * @param Entity\Meet          $meet
     * @param Entity\EventTemplate $eventTemplate
     * @param string               $gender
     *
     * @return string
     */
    private function getKey(Entity\Meet $meet, Entity\EventTemplate $eventTemplate, $gender)
    {
        return $meet->getId() . '_' . $eventTemplate->getId() . '_' . $gender;
    }

    /**
     * @return Entity\Event[]
     */
    public function &findEvents()
    {
        if ($this->events === null) {
            $events = $this->repository->findAll();
            $result = array();
            foreach($events as $event) {
                $result[$this->getKey($event->getMeet(), $event->getEventTemplate(), $event->getGender())] = $event;
            }
            $this->events = $result;
        }

        return $this->events;
    }

    /**
     * @param Entity\Meet          $meet
     * @param Entity\EventTemplate $eventTemplate
     * @param string               $gender
     *
     * @return Entity\Event
     */
    public function findOrCreate(Entity\Meet $meet, Entity\EventTemplate $eventTemplate, $gender)
    {
        $events = &$this->findEvents();
        $key = $this->getKey($meet, $eventTemplate, $gender);
        if (!isset($events[$key])) {
            $event = new Entity\Event();
            $event->setMeet($meet);
            $event->setEventTemplate($eventTemplate);
            $event->setGender($gender);

            $em = $this->doctrine->getManager();
            $em->persist($event);
            $em->flush();
            $events[$key] = $event;
        }
        return $events[$key];
    }

//    /**
//     * @return array
//     */
//    public function findEvents()
//    {
//        $aEvents = $this->repository->findEvents();
//
//        $aResult = array();
//        foreach($aEvents as $event) {
//            $aResult[] = array(
//                'key' => json_encode(array(
//                    'distanceId' => $event['distanceId'],
//                    'styleId' => $event['styleId'],
//                    'courseId' => $event['courseId'],
//                )),
//                'value' => $event['distance'] . ' ' . $event['style'] . ' ' . $event['course']
//            );
//        }
//
//        return $aResult;
//    }
}