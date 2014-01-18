<?php
/**
 * User: Nikita
 * Date: 12.01.14
 * Time: 10:50
 */

namespace Sp\PaymentBundle\Controller;

use Sp\PaymentBundle\Entity\Order;
use Sp\PaymentBundle\Model\PaymentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/payment")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/order", name="payment_order")
     * @Template()
     */
    public function orderAction()
    {
        return [];
    }

    /**
     * @Route("/checkout", name="payment_checkout")
     */
    public function checkoutAction()
    {
        return $this->getPaymentManager()->checkout(array(1), 'checkout_complete', 'checkout_cancel');
    }

    /**
     * @Route("/{id}/complete", name="checkout_complete")
     */
    public function completeAction(Order $order)
    {
        $result = $this->getPaymentManager()->complete($order);

        return ($result instanceof RedirectResponse) ? $result : $this->redirect($this->generateUrl('payment_order'));
    }

    /**
     * @Route("/{$id}/cancel", name="checkout_cancel")
     */
    public function cancelAction($id)
    {
        $this->get('session')->getFlashBag()->add('info', 'Transaction canceled');
        return $this->redirect($this->generateUrl('payment_order'));
    }

    /**
     * @return PaymentManager
     */
    public function getPaymentManager()
    {
        return $this->get('sp_payment.payment_manager');
    }
}