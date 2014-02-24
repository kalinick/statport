<?php
/**
 * User: Nikita
 * Date: 15.09.13
 * Time: 12:09
 */


namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="lsc")
 */
class Lsc
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
     * @ORM\OneToMany(targetEntity="EventResult", mappedBy="lsc")
     */
    private $eventResults;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eventResults = new ArrayCollection();
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
     * @return Lsc
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
     * Add eventResults
     *
     * @param EventResult $eventResults
     * @return Lsc
     */
    public function addEventResult(EventResult $eventResults)
    {
        $this->eventResults[] = $eventResults;

        return $this;
    }

    /**
     * Remove eventResults
     *
     * @param EventResult $eventResults
     */
    public function removeEventResult(EventResult $eventResults)
    {
        $this->eventResults->removeElement($eventResults);
    }

    /**
     * Get event results
     *
     * @return Collection
     */
    public function getEventResults()
    {
        return $this->eventResults;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}