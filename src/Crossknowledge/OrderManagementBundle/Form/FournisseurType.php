<?php

namespace Crossknowledge\OrderManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('codeFournisseur', 'text', array('label' => 'fournisseur.code'))
            ->add('typeFournisseur', 'text', array('label' => 'fournisseur.type'))
            ->add('raisonSociale', 'text', array('label' => 'fournisseur.raisonsociale'))
            ->add('contact', 'text', array('label' => 'fournisseur.contact'))
            ->add('telephone', 'text', array('label' => 'fournisseur.phone'))
            ->add('mail', 'text', array('label' => 'fournisseur.mail'))
            ->add('adresseFacturation', 'textarea', array('label' => 'fournisseur.address'))
            ->add('caCommande', 'number', array('label' => 'fournisseur.CAorder'))
            ->add('caLettre', 'number', array('label' => 'fournisseur.CAlettre'))
            ->add('devise', 'choice', array('label' => 'fournisseur.devise', 
                                            'choices' => array('€' => '€',
                                                               '$' => '$',
                                                               '£' => '£',
             )))
        ;
    }

    public function getName()
    {
        return 'crossknowledge_ordermanagementbundle_fournisseurtype';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Crossknowledge\OrderManagementBundle\Entity\Fournisseur',
        );
    }
}
