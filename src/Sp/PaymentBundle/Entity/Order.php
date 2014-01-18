<?php
/**
 * User: Nikita
 * Date: 12.01.14
 * Time: 14:58
 */

namespace Sp\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;

/**
 * @ORM\Entity
 * @ORM\Table(name="swimmers_order")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="JMS\Payment\CoreBundle\Entity\PaymentInstruction")
     */
    private $paymentInstruction;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

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
     * Set amount
     *
     * @param string $amount
     * @return Order
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set paymentInstruction
     *
     * @param PaymentInstruction $paymentInstruction
     * @return Order
     */
    public function setPaymentInstruction(PaymentInstruction $paymentInstruction = null)
    {
        $this->paymentInstruction = $paymentInstruction;
    
        return $this;
    }

    /**
     * Get paymentInstruction
     *
     * @return PaymentInstruction
     */
    public function getPaymentInstruction()
    {
        return $this->paymentInstruction;
    }
}