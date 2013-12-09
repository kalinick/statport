<?php
/**
 * User: nikk
 * Date: 11/25/13
 * Time: 6:09 PM
 */

namespace Sp\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sp\AppBundle\Entity\ProcessState;

/**
 * @ORM\Entity
 * @ORM\Table(name="unprocessed_result_transaction")
 * @ORM\HasLifecycleCallbacks()
 */
class UnprocessedResultTransaction
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
     * @ORM\ManyToOne(targetEntity="Sp\AppBundle\Entity\ProcessState")
     * @ORM\JoinColumn(name="process_state_id", referencedColumnName="id", nullable=false)
     */
    private $processState;

    /**
     * @ORM\OneToMany(targetEntity="UnprocessedResult", mappedBy="transaction")
     */
    private $results;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

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
     * @return UnprocessedResultTransaction
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
     * Add results
     *
     * @param UnprocessedResult $results
     * @return UnprocessedResultTransaction
     */
    public function addResult(UnprocessedResult $results)
    {
        $this->results[] = $results;
    
        return $this;
    }

    /**
     * Remove results
     *
     * @param UnprocessedResult $results
     */
    public function removeResult(UnprocessedResult $results)
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return UnprocessedResultTransaction
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function onCreated()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Set processState
     *
     * @param ProcessState $processState
     * @return UnprocessedResultTransaction
     */
    public function setProcessState(ProcessState $processState = null)
    {
        $this->processState = $processState;
    
        return $this;
    }

    /**
     * Get processState
     *
     * @return ProcessState
     */
    public function getProcessState()
    {
        return $this->processState;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}