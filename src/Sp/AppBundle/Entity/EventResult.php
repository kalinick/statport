<?php
/**
 * User: Nikita
 * Date: 07.09.13
 * Time: 0:11
 */

namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="event_result")
 */
class EventResult
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="Swimmer")
     * @ORM\JoinColumn(name="swimmer_id", referencedColumnName="id", nullable=false)
     */
    private $swimmer;

    /**
     * @ORM\Column(type="float")
     */
    private $seconds;

    /**
     * @ORM\Column(type="integer")
     */
    private $rank;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

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
     * Set seconds
     *
     * @param float $seconds
     * @return EventResult
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
     * Set event
     *
     * @param Event $event
     * @return EventResult
     */
    public function setEvent(Event $event = null)
    {
        $this->event = $event;
    
        return $this;
    }

    /**
     * Get event
     *
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set swimmer
     *
     * @param Swimmer $swimmer
     * @return EventResult
     */
    public function setSwimmer(Swimmer $swimmer = null)
    {
        $this->swimmer = $swimmer;
    
        return $this;
    }

    /**
     * Get swimmer
     *
     * @return Swimmer
     */
    public function getSwimmer()
    {
        return $this->swimmer;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return EventResult
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
    
        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return EventResult
     */
    public function setAge($age)
    {
        $this->age = $age;
    
        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }
}