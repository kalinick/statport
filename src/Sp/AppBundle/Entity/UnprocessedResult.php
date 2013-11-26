<?php
/**
 * User: nikk
 * Date: 11/25/13
 * Time: 6:13 PM
 */

namespace Sp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="unprocessed_result")
 */
class UnprocessedResult
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UnprocessedResultTransaction")
     * @ORM\JoinColumn(name="transaction_id", referencedColumnName="id")
     */
    private $transaction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="ProcessState")
     * @ORM\JoinColumn(name="process_state_id", referencedColumnName="id")
     */
    private $processState;

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
     * Set value
     *
     * @param string $value
     * @return UnprocessedResult
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set transaction
     *
     * @param UnprocessedResultTransaction $transaction
     * @return UnprocessedResult
     */
    public function setTransaction(UnprocessedResultTransaction $transaction = null)
    {
        $this->transaction = $transaction;
    
        return $this;
    }

    /**
     * Get transaction
     *
     * @return UnprocessedResultTransaction
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Set processState
     *
     * @param ProcessState $processState
     * @return UnprocessedResult
     */
    public function setProcessState(ProcessState $processState = null)
    {
        $this->processState = $processState;
    
        return $this;
    }

    /**
     * Get processState
     *
     * @return \Sp\AppBundle\Entity\ProcessState 
     */
    public function getProcessState()
    {
        return $this->processState;
    }
}