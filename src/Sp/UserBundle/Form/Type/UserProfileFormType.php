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
use Doctrine\ORM\EntityRepository;

class UserProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName');
        $builder->add('lastName');
        $builder->add('address');
        $builder->add('city');
        $builder->add('state', 'entity', array(
            'class' => 'SpAppBundle:State',
            'empty_value' => 'Choose a state',
            'required' => false,
            'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.title', 'ASC');
                },
        ));
        $builder->add('zip');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Sp\AppBundle\Entity\UserProfile'
        ));
    }

    public function getName()
    {
        return 'user_profile_form_type';
    }
}