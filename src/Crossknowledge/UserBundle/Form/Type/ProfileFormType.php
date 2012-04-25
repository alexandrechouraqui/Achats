<?php

namespace Crossknowledge\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildUserForm(FormBuilder $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        // add your custom field
        $builder
            ->add('nom')
            ->add('prenom')
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