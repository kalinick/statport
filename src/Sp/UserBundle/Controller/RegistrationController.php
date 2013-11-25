<?php
/**
 * User: Nikita
 * Date: 19.11.13
 * Time: 20:53
 */

namespace Sp\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
{
    public function registerAction()
    {

        $response = parent::registerAction();


        return $response;
    }
}