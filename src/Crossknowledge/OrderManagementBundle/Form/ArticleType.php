<?php

namespace Crossknowledge\OrderManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('codeArticle', 'text', array('label' => 'article.code'))
            ->add('typeArticle', 'text', array('label' => 'article.designation'))
        ;
    }

    public function getName()
    {
        return 'crossknowledge_ordermanagementbundle_articletype';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Crossknowledge\OrderManagementBundle\Entity\Article',
        );
    }
}
