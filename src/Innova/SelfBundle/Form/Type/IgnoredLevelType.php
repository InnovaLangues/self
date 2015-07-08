<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IgnoredLevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('skill', 'entity', array(
            'class' => 'InnovaSelfBundle:Skill',
            'property' => 'name',
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.threshold.skill',
            'translation_domain' => 'messages',
        ));

        $builder->add('componentType', 'entity', array(
            'class' => 'InnovaSelfBundle:PhasedTest\ComponentType',
            'property' => 'name',
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.componentTypeOut',
            'translation_domain' => 'messages',
        ));

        $builder->add('levels', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'label'  => 'phased.ignoredLevels',
            'translation_domain' => 'messages',
            'multiple' => true,
            'required' => false,
            'expanded' => true,
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Innova\SelfBundle\Entity\PhasedTest\IgnoredLevel',
        ));
    }

    public function getName()
    {
        return 'ignoredLevel';
    }
}
