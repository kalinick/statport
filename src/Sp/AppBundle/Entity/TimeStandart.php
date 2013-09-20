<?php
/**
 * User: Nikita
 * Date: 12.09.13
 * Time: 20:00
 */

namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="Sp\AppBundle\Repository\TimeStandartRepository")
 * @ORM\Table(name="time_standart")
 */
class TimeStandart
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity="TimeStandartResult", mappedBy="timeStandart")
     */
    private $timeStandartResults;
    /**
     * Constructor
     */
    public function __construct()
    {
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
     * @return TimeStandart
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
     * Add timeStandartResults
     *
     * @param TimeStandartResult $timeStandartResults
     * @return TimeStandart
     */
    public function addTimeStandartResult(TimeStandartResult $timeStandartResults)
    {
        $this->timeStandartResults[] = $timeStandartResults;
    
        return $this;
    }

    /**
     * Remove timeStandartResults
     *
     * @param TimeStandartResult $timeStandartResults
     */
    public function removeTimeStandartResult(TimeStandartResult $timeStandartResults)
    {
        $this->timeStandartResults->removeElement($timeStandartResults);
    }

    /**
     * Get timeStandartResults
     *
     * @return Collection
     */
    public function getTimeStandartResults()
    {
        return $this->timeStandartResults;
    }
}