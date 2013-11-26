<?php
/**
 * User: nikk
 * Date: 11/25/13
 * Time: 6:35 PM
 */

namespace Sp\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class UnprocessedResultTransactionAdmin extends Admin
{
//    protected function configureRoutes(RouteCollection $collection)
//    {
//        $collection
//            ->clearExcept(['list'])
//        ;
//    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->addIdentifier('processState')
            ->addIdentifier('createdAt')
        ;
    }

    public function getBatchActions()
    {
        return [];
    }
}