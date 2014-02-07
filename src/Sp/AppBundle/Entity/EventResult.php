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
     * @ORM\ManyToOne(targetEntity="Lsc")
     * @ORM\JoinColumn(name="lsc_id", referencedColumnName="id", nullable=false)
     */
    private $lsc;

    /**
     * @ORM\ManyToOne(targetEntity="Club")
     * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
     */
    private $club;

    /**
     * @ORM\Column(type="string", name="ts", length=255)
     */
    private $ts;

    /**
     * @ORM\Column(type="string", name="relay", length=1)
     */
    private $relay;

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
     * Set lsc
     *
     * @param Lsc $lsc
     * @return Swimmer
     */
    public function setLsc(Lsc $lsc)
    {
        $this->lsc = $lsc;

        return $this;
    }

    /**
     * Get lsc
     *
     * @return Lsc
     */
    public function getLsc()
    {
        return $this->lsc;
    }

    /**
     * Set club
     *
     * @param Club $club
     * @return Swimmer
     */
    public function setClub(Club $club)
    {
        $this->club = $club;

        return $this;
    }

    /**
     * Get club
     *
     * @return Club
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * Set ts
     *
     * @param string $ts
     * @return EventResult
     */
    public function setTs($ts)
    {
        $this->ts = $ts;

        return $this;
    }

    /**
     * Get ts
     *
     * @return string
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * Set relay
     *
     * @param string $relay
     * @return EventResult
     */
    public function setRelay($relay)
    {
        $this->relay = $relay;

        return $this;
    }

    /**
     * Get relay
     *
     * @return string
     */
    public function getRelay()
    {
        return $this->relay;
    }
}