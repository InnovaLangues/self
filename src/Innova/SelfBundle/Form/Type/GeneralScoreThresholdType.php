<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GeneralScoreThresholdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('componentType', 'entity', array(
            'class' => 'InnovaSelfBundle:PhasedTest\ComponentType',
            'property' => 'name',
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.componentType',
            'translation_domain' => 'messages',
        ));

        $builder->add('rightAnswers', 'integer', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.rightAnswers',
            'translation_domain' => 'messages',
        ));

        $builder->add('level', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.level',
            'translation_domain' => 'messages',
        ));

        $builder->add('description', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.description',
            'translation_domain' => 'messages',
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Innova\SelfBundle\Entity\PhasedTest\GeneralScoreThreshold',
        ));
    }

    public function getName()
    {
        return 'generalScoreThreshold';
    }
}
