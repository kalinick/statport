<?php
/**
 * User: nikk
 * Date: 12/23/13
 * Time: 5:50 PM
 */

namespace Sp\UserBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;
use Sp\AppBundle\Model\SwimmerManager;

class RegistrationFormHandler extends BaseHandler
{
    /**
     * @var SwimmerManager
     */
    private $swimmerManager;

    /**
     * @param SwimmerManager $swimmerManager
     *
     * @return RegistrationFormHandler
     */
    public function setSwimmerManager(SwimmerManager $swimmerManager)
    {
        $this->swimmerManager = $swimmerManager;

        return $this;
    }

    /**
     * @return SwimmerManager
     */
    public function getSwimmerManager()
    {
        return $this->swimmerManager;
    }

    /**
     * @param bool $confirmation
     * @return bool
     */
    public function process($confirmation = false)
    {
        /* @var \Sp\AppBundle\Entity\User $user*/
        $user = $this->createUser();
        $this->form->setData($user);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);
            $user->getProfile()->setUser($user);
            foreach($user->getChildren() as $child) {
                $child->setUser($user);
            }
            if ($this->form->isValid()) {
                $this->onSuccess($user, $confirmation);

                $this->getSwimmerManager()->assignSwimmersToChildren($user->getChildren());

                return true;
            }
        }

        return false;
    }
}