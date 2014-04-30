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
    private $results;

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
     * Add result
     *
     * @param EventResult $result
     *
     * @return Lsc
     */
    public function addEventResult(EventResult $result)
    {
        $this->results[] = $result;

        return $this;
    }

    /**
     * Remove result
     *
     * @param EventResult $result
     */
    public function removeEventResult(EventResult $result)
    {
        $this->results->removeElement($result);
    }

    /**
     * Get event results
     *
     * @return Collection
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }
}