<?php
/**
 * User: nikk
 * Date: 12/23/13
 * Time: 5:50 PM
 */

namespace Sp\UserBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;

class RegistrationFormHandler extends BaseHandler
{
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
            if ($this->form->isValid()) {
                $this->onSuccess($user, $confirmation);

                return true;
            }
        }

        return false;
    }
}