<?php
/**
 * User: nikk
 * Date: 11/28/13
 * Time: 4:05 PM
 */

namespace Sp\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UnprocessedResultAdmin extends Admin
{
    protected $parentAssociationMapping = 'unprocessedresulttransaction';

    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('transaction')
            ->addIdentifier('processState')
            ->addIdentifier('value')
        ;
    }

    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('transaction')
            ->add('processState', 'entity', ['class' => 'SpAppBundle:ProcessState'])
            ->add('value')
            ->end();
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('transaction')
            ->add('processState')
            ->add('value')
        ;
    }

    public function getBatchActions()
    {
        return [];
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid)
    {
        $datagrid
            ->add('unprocessedresulttransaction', 'doctrine_orm_callback', [
                'callback' => function($queryBuilder, $alias, $field, $value) {
                        if (!empty($value['value'])) {
                            $queryBuilder->andWhere('o.transaction = :transactionId');
                            $queryBuilder->setParameter('transactionId', $value['value']);
                        }
                        return true;
                    },
                'field_type' => 'hidden'
            ]);
    }
}