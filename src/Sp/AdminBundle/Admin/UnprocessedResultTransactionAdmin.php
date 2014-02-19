<?php
/**
 * User: nikk
 * Date: 11/25/13
 * Time: 6:35 PM
 */

namespace Sp\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UnprocessedResultTransactionAdmin extends Admin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('import');
    }

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('title')
            ->addIdentifier('processState')
            ->addIdentifier('createdAt')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'results' => array('template' => 'SpAdminBundle:UnprocessedResultTransaction:results.html.twig'),
                )
            ))
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('processState', 'entity', array('class' => 'SpAppBundle:ProcessState'))
            ->end();
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('title')
            ->add('processState')
            ->add('createdAt')
        ;
    }

    public function getBatchActions()
    {
        return array();
    }
}