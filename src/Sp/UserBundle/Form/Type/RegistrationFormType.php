<?php
/**
 * User: nikk
 * Date: 12/9/13
 * Time: 5:31 PM
 */

namespace Sp\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('profile', new UserProfileFormType());

        parent::buildForm($builder, $options);
    }

    public function getName()
    {
        return 'fos_user_registration';
    }
}