<?php
/**
 * User: nikk
 * Date: 12/10/13
 * Time: 4:23 PM
 */

namespace Sp\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChildrenFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName');
        $builder->add('lastName');
        $builder->add('birthday');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sp\AppBundle\Entity\UserChild'
        ));
    }

    public function getName()
    {
        return 'user_child_form_type';
    }
}