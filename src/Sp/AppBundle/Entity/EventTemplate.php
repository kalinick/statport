<?php
/**
 * User: Nikita
 * Date: 06.09.13
 * Time: 22:35
 */

namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="Sp\AppBundle\Repository\EventTemplateRepository")
 * @ORM\Table(name="event_template")
 */
class EventTemplate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Distance")
     * @ORM\JoinColumn(name="distance_id", referencedColumnName="id", nullable=false)
     */
    private $distance;

    /**
     * @ORM\ManyToOne(targetEntity="SwimmingStyle")
     * @ORM\JoinColumn(name="style_id", referencedColumnName="id", nullable=false)
     */
    private $style;

    /**
     * @ORM\ManyToOne(targetEntity="Course")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=false)
     */
    private $course;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="eventTemplate")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="TimeStandartResult", mappedBy="eventTemplate")
     */
    private $timeStandartResults;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->timeStandartResults = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return EventTemplate
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set distance
     *
     * @param Distance $distance
     * @return EventTemplate
     */
    public function setDistance(Distance $distance = null)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return Distance
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set style
     *
     * @param SwimmingStyle $style
     * @return EventTemplate
     */
    public function setStyle(SwimmingStyle $style = null)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return SwimmingStyle
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set course
     *
     * @param Course $course
     * @return EventTemplate
     */
    public function setCourse(Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Add events
     *
     * @param Event $event
     * @return EventTemplate
     */
    public function addEvent(Event $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param Event $event
     */
    public function removeEvent(Event $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add time standart result
     *
     * @param TimeStandartResult $timeStandartResult
     * @return EventTemplate
     */
    public function addTimeStandartResults(TimeStandartResult $timeStandartResult)
    {
        $this->timeStandartResults[] = $timeStandartResult;

        return $this;
    }

    /**
     * Remove time standart result
     *
     * @param TimeStandartResult $timeStandartResult
     */
    public function removeTimeStandartResult(TimeStandartResult $timeStandartResult)
    {
        $this->timeStandartResults->removeElement($timeStandartResult);
    }

    /**
     * Add timeStandartResults
     *
     * @param TimeStandartResult $timeStandartResults
     * @return EventTemplate
     */
    public function addTimeStandartResult(TimeStandartResult $timeStandartResults)
    {
        $this->timeStandartResults[] = $timeStandartResults;

        return $this;
    }

    /**
     * Get time standart result
     *
     * @return Collection
     */
    public function getTimeStandartResults()
    {
        return $this->timeStandartResults;
    }
}