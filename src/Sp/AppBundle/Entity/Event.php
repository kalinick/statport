<?php
/**
 * User: nikk
 * Date: 2/4/14
 * Time: 3:13 PM
 */

namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Sp\AppBundle\Repository\EventRepository")
 * @ORM\Table(name="event")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Meet", inversedBy="events")
     * @ORM\JoinColumn(name="meet_id", referencedColumnName="id", nullable=false)
     */
    private $meet;

    /**
     * @ORM\OneToMany(targetEntity="EventResult", mappedBy="event")
     */
    private $results;

    /**
     * @ORM\ManyToOne(targetEntity="EventTemplate", inversedBy="events")
     * @ORM\JoinColumn(name="event_template_id", referencedColumnName="id", nullable=false)
     */
    private $eventTemplate;

    /**
     * @Assert\NotBlank()
     * @Assert\Choice(choices = {"M", "F"}, message = "Choose a valid gender.")
     * @ORM\Column(type="string", length=1)
     */
    private $gender;

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
     * Set event template
     *
     * @param EventTemplate $eventTemplate
     * @return Event
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
     * Set gender
     *
     * @param string $gender
     * @return Event
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