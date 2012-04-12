<?php

namespace Crossknowledge\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder
            ->add('isManager')
            ->add('budget')
            ->add('budgetRestant')    
        ;
    }

    public function getName()
    {
        return 'crossknowledge_user_profile';
    }
}