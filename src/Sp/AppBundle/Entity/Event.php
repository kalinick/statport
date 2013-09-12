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
 * @ORM\Entity
 * @ORM\Table(name="event")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Meet")
     * @ORM\JoinColumn(name="meet_id", referencedColumnName="id")
     */
    protected $meet;

    /**
     * @ORM\ManyToOne(targetEntity="Distance")
     * @ORM\JoinColumn(name="distance_id", referencedColumnName="id")
     */
    protected $distance;

    /**
     * @ORM\ManyToOne(targetEntity="SwimmingStyle")
     * @ORM\JoinColumn(name="style_id", referencedColumnName="id")
     */
    protected $style;

    /**
     * @ORM\ManyToOne(targetEntity="Course")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    protected $course;

    /**
     * @ORM\OneToMany(targetEntity="EventResult", mappedBy="event")
     */
    private $results;

    /**
     * @ORM\Column(type="integer")
     */
    private $resultsNum;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->results = new ArrayCollection();
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
     * Set distance
     *
     * @param Distance $distance
     * @return Event
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
     * @return Event
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
     * @return Event
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
     * Set meet
     *
     * @param Meet $meet
     * @return Event
     */
    public function setMeet(Meet $meet = null)
    {
        $this->meet = $meet;
    
        return $this;
    }

    /**
     * Get meet
     *
     * @return Meet
     */
    public function getMeet()
    {
        return $this->meet;
    }

    /**
     * Add results
     *
     * @param EventResult $results
     * @return Event
     */
    public function addResult(EventResult $results)
    {
        $this->results[] = $results;
    
        return $this;
    }

    /**
     * Remove results
     *
     * @param EventResult $results
     */
    public function removeResult(EventResult $results)
    {
        $this->results->removeElement($results);
    }

    /**
     * Get results
     *
     * @return Collection
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set resultsNum
     *
     * @param integer $resultsNum
     * @return Event
     */
    public function setResultsNum($resultsNum)
    {
        $this->resultsNum = $resultsNum;
    
        return $this;
    }

    /**
     * Get resultsNum
     *
     * @return integer 
     */
    public function getResultsNum()
    {
        return $this->resultsNum;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getDistance() . ' ' . $this->getStyle() . ' ' . $this->getCourse();
    }
}