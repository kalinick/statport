<?php
/**
 * User: Nikita
 * Date: 12.01.14
 * Time: 14:02
 */

namespace Sp\PaymentBundle\Model;

use Doctrine\Bundle\DoctrineBundle\Registry;
use JMS\Payment\CoreBundle\Entity\ExtendedData;
use Sp\PaymentBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use JMS\Payment\CoreBundle\Entity\PaymentInstruction;
use JMS\Payment\CoreBundle\PluginController\PluginController;
use JMS\Payment\CoreBundle\PluginController\Result;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;

class PaymentManager
{
    /**
     * @var Registry
     */
    private $doctrine;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var PluginController
     */
    private $ppc;

    /**
     * @param Registry $doctrine
     * @param Router $router
     * @param PluginController $ppc
     */
    public function __construct(Registry $doctrine, Router $router, PluginController $ppc)
    {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->ppc = $ppc;
    }

    /**
     * @param array $children
     * @param $completeUrlName
     * @param $cancelUrlName
     * @return RedirectResponse
     * @throws \RuntimeException
     */
    public function checkout(array $children, $completeUrlName, $cancelUrlName)
    {
        // TODO: need create real data
        $price = 14.99;
        $amount = $price * count($children);

        $em = $this->doctrine->getManager();
        $order = new Order();
        $order->setAmount($amount);
        $em->persist($order);
        $em->flush();

        $extendedData = new ExtendedData();
        $extendedData->set('return_url',
            $this->router->generate($completeUrlName, array('id' => $order->getId()), true));
        $extendedData->set('cancel_url',
            $this->router->generate($cancelUrlName, array('id' => $order->getId()), true));

        $checkout_params = array('PAYMENTREQUEST_0_AMT' => $amount,
            'PAYMENTREQUEST_0_ITEMAMT' => $amount,
            'PAYMENTREQUEST_0_PAYMENTACTION', "Sale");

        foreach ($children as $i => $child) {
            $checkout_params["L_PAYMENTREQUEST_0_NAME$i"] = $child;
            $checkout_params["L_PAYMENTREQUEST_0_AMT$i"] = $price;
        }
        $extendedData->set('checkout_params', $checkout_params);

        $instruction = new PaymentInstruction($amount, "USD", "paypal_express_checkout", $extendedData);
        $this->ppc->createPaymentInstruction($instruction);
        $order->setPaymentInstruction($instruction);
        $em->persist($order);
        $em->flush();

        $payment = $this->ppc->createPayment($instruction->getId(), $instruction->getAmount());
        $result = $this->ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());

        if ($result->getStatus() === Result::STATUS_PENDING) {
            $ex = $result->getPluginException();
            $action = $ex->getAction();
            return new RedirectResponse($action->getUrl());
        }

        throw new \RuntimeException('Checkout crashed, reason code : ' . $result->getReasonCode());
    }

    /**
     * @param Order $order
     * @return bool|RedirectResponse
     * @throws \RuntimeException
     * @throws ActionRequiredException
     */
    public function complete(Order $order)
    {
        $instruction = $order->getPaymentInstruction();
        if (null === $pendingTransaction = $instruction->getPendingTransaction()) {
            $payment = $this->ppc->createPayment($instruction->getId(), $instruction->getAmount() - $instruction->getDepositedAmount());
        } else {
            $payment = $pendingTransaction->getPayment();
        }
        $result = $this->ppc->approveAndDeposit($payment->getId(), $payment->getTargetAmount());
        if (Result::STATUS_PENDING === $result->getStatus()) {
            $ex = $result->getPluginException();
            if ($ex instanceof ActionRequiredException) {
                $action = $ex->getAction();
                if ($action instanceof VisitUrl) {
                    return new RedirectResponse($action->getUrl());
                }
                throw $ex;
            }
        } elseif (Result::STATUS_SUCCESS !== $result->getStatus()) {
            throw new \RuntimeException('Transaction was not completed: ' . $result->getReasonCode());
        }

        // TODO: activate swimmers

        return true;
    }
}