<?php

namespace Crossknowledge\OrderManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('typeCommande', 'choice', array('label' => 'commande.type',
                                                  'choices' => array( 'Budget' => 'Budget',
                                                                      'Hors Budget' => 'Hors Budget'    
            )))
            ->add('fournisseur', 'entity', array('class' => 'CrossknowledgeOrderManagementBundle:Fournisseur', 'property' => 'raisonSociale', 'label' => 'commande.fournisseur'))
            ->add('designation', 'text', array('label'=>'commande.designation'))
        ;
    }

    public function getName()
    {
        return 'crossknowledge_ordermanagementbundle_commandetype';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Crossknowledge\OrderManagementBundle\Entity\Commande',
        );
    }
}
