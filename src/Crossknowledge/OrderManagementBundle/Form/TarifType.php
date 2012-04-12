<?php

namespace Crossknowledge\OrderManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TarifType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('prix', 'number', array('label' => 'tarif.prix'))
            ->add('ancienPrix', 'number', array('label' => 'tarif.ancienprix', 'precision' => '2'))
            ->add('tva', 'number', array('label' => 'tarif.tva'))    
            ->add('fournisseur', 'entity', array('class' => 'CrossknowledgeOrderManagementBundle:Fournisseur', 'property' => 'raisonSociale', 'label'=>'tarif.fournisseur','empty_value' => 'Sélectionnez un fournisseur'))
            ->add('article', 'entity', array('class' => 'CrossknowledgeOrderManagementBundle:Article', 'property' => 'typeArticle', 'label'=>'tarif.article','empty_value' => 'Sélectionnez un article'))
        ;
    }

    public function getName()
    {
        return 'crossknowledge_ordermanagementbundle_tariftype';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Crossknowledge\OrderManagementBundle\Entity\Tarif',
        );
    }
}
