<?php
/**
 * User: Nikita
 * Date: 12.09.13
 * Time: 20:04
 */

namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="Sp\AppBundle\Repository\TimeStandartResultRepository")
 * @ORM\Table(name="time_standart_result")
 */
class TimeStandartResult
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @ORM\ManyToOne(targetEntity="TimeStandart")
     * @ORM\JoinColumn(name="time_standart_id", referencedColumnName="id", nullable=false)
     */
    private $timeStandart;

    /**
     * @ORM\Column(type="string", type="string", length=1)
     */
    private $gender;

    /**
     * @ORM\Column(type="integer", name="min_age")
     */
    private $minAge;

    /**
     * @ORM\Column(type="integer", name="max_age")
     */
    private $maxAge;

    /**
     * @ORM\Column(type="float")
     */
    private $seconds;

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
     * Set minAge
     *
     * @param integer $minAge
     * @return TimeStandartResult
     */
    public function setMinAge($minAge)
    {
        $this->minAge = $minAge;
    
        return $this;
    }

    /**
     * Get minAge
     *
     * @return integer 
     */
    public function getMinAge()
    {
        return $this->minAge;
    }

    /**
     * Set maxAge
     *
     * @param integer $maxAge
     * @return TimeStandartResult
     */
    public function setMaxAge($maxAge)
    {
        $this->maxAge = $maxAge;
    
        return $this;
    }

    /**
     * Get maxAge
     *
     * @return integer 
     */
    public function getMaxAge()
    {
        return $this->maxAge;
    }

    /**
     * Set seconds
     *
     * @param float $seconds
     * @return TimeStandartResult
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;
    
        return $this;
    }

    /**
     * Get seconds
     *
     * @return float 
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * Set distance
     *
     * @param Distance $distance
     * @return TimeStandartResult
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
     * @return TimeStandartResult
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
     * Set timeStandart
     *
     * @param TimeStandart $timeStandart
     * @return TimeStandartResult
     */
    public function setTimeStandart(TimeStandart $timeStandart = null)
    {
        $this->timeStandart = $timeStandart;
    
        return $this;
    }

    /**
     * Get timeStandart
     *
     * @return TimeStandart
     */
    public function getTimeStandart()
    {
        return $this->timeStandart;
    }

    /**
     * Set course
     *
     * @param Course $course
     * @return TimeStandartResult
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
     * Set gender
     *
     * @param string $gender
     * @return TimeStandartResult
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }
}