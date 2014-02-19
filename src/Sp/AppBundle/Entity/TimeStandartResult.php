<?php
/**
 * User: Nikita
 * Date: 12.09.13
 * Time: 20:04
 */

namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity="EventTemplate")
     * @ORM\JoinColumn(name="event_template_id", referencedColumnName="id", nullable=false)
     */
    private $eventTemplate;

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
     * Set event template
     *
     * @param EventTemplate $eventTemplate
     * @return TimeStandartResult
     */
    public function setEventTemplate(EventTemplate $eventTemplate = null)
    {
        $this->eventTemplate = $eventTemplate;

        return $this;
    }

    /**
     * Get event template
     *
     * @return EventTemplate
     */
    public function getEventTemplate()
    {
        return $this->eventTemplate;
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