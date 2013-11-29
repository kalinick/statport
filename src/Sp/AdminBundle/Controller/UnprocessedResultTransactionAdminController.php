<?php
/**
 * User: nikk
 * Date: 11/28/13
 * Time: 4:10 PM
 */

namespace Sp\AdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class UnprocessedResultTransactionAdminController extends Controller
{
    public function importAction()
    {
        //TODO: implement logic


        return self::listAction();
    }
}