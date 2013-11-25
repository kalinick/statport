<?php
/**
 * User: Nikita
 * Date: 06.09.13
 * Time: 22:24
 */

namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="distance")
 */
class Distance
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="distance")
     */
    private $events;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
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
     * Set length
     *
     * @param integer $length
     * @return Distance
     */
    public function setLength($length)
    {
        $this->length = $length;
    
        return $this;
    }

    /**
     * Get length
     *
     * @return integer 
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Add events
     *
     * @param Event $events
     * @return Distance
     */
    public function addEvent(Event $events)
    {
        $this->events[] = $events;
    
        return $this;
    }

    /**
     * Remove events
     *
     * @param Event $events
     */
    public function removeEvent(Event $events)
    {
        $this->events->removeElement($events);
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getLength();
    }
}