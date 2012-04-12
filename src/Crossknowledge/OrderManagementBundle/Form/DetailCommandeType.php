<?php

namespace Crossknowledge\OrderManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DetailCommandeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
//            ->add('type', 'choice', array('label' => 'Type', 'read_only' => true,
//                'choices' => array( 'DA' => 'Demande d\'achat',
//                                    'OA' => 'Ordre d\'achat'
//                  )))
            ->add('BU','choice', array('label' => 'detailcommande.service','empty_value' => 'Sélectionnez votre service',
                'choices' => array( 'BU FR 1'           => 'BU FR 1', 
                                    'BU FR 2'           => 'BU FR 2', 
                                    'BU ESMB'           => 'BU ESMB',
                                    'Admin'             => 'Administration',
                                    'Marketing'         => 'Marketing',
                                    'Solutions'         => 'Solutions',
                                    'Opérations France' => 'Opérations France'
                  )))
            ->add('designation', 'text', array('label' => 'detailcommande.designation'))
            ->add('lettrage', 'checkbox',array('label' => 'detailcommande.lettering', 'required' => false))
            ->add('quantite','integer', array('label' => 'detailcommande.quantite'))
            ->add('dateLivraison', 'date',array('label' => 'detailcommande.datelivraison',
                                                'widget' => 'single_text',
                                                'input' => 'datetime',
                                                'format' => 'dd/MM/yyyy',
                                                'attr' => array('class' => 'date')))
            ->add('remarque', 'textarea', array('label' => 'detailcommande.remarque', 'required' => false))
            ->add('accordBUM', 'checkbox', array('label' => 'detailcommande.accord', 'required' => false))
            ->add('prixHT', 'number', array('label' => 'detailcommande.prixht', 'required' => false))
            ->add('tva', 'number', array('label' => 'detailcommande.tva', 'precision' => '1'))
            ->add('prixTTC', 'hidden', array('label' => 'detailcommande.prixttc'))
            ->add('article', 'entity', array('class' => 'CrossknowledgeOrderManagementBundle:Article', 'label' => 'detailcommande.article','empty_value' => 'Sélectionnez un article', 'empty_data'  => null, 'property' => 'typeArticle'))
            ->add('assignedTo', 'entity', array('class' => 'CrossknowledgeUserBundle:Utilisateur', 'label' => 'detailcommande.assignedto', 'empty_value' => 'Sélectionnez votre manager'))
            ->add('client', 'text', array('label' => 'detailcommande.client'))
        ;
    }

    public function getName()
    {
        return 'crossknowledge_ordermanagementbundle_detailcommandetype';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Crossknowledge\OrderManagementBundle\Entity\DetailCommande',
        );
    }
}
