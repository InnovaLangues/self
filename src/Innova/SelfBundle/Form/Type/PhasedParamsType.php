<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PhasedParamsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('step2Threshold', 'integer', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.step2Threshold',
            'translation_domain' => 'messages',
        ));

        $builder->add('step3Threshold', 'integer', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.step3Threshold',
            'translation_domain' => 'messages',
        ));

        $builder->add('step4Threshold', 'integer', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.step4Threshold',
            'translation_domain' => 'messages',
        ));

        $builder->add('lowerPart1', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control identity-select'),
            'label'  => 'phased.lowerpart1',
            'translation_domain' => 'messages',
        ));

        $builder->add('upperPart1', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control identity-select'),
            'label'  => 'phased.upperpart1',
            'translation_domain' => 'messages',
        ));

        $builder->add('lowerPart2', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control identity-select'),
            'label'  => 'phased.lowerpart2',
            'translation_domain' => 'messages',
        ));

        $builder->add('upperPart2', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control identity-select'),
            'label'  => 'phased.upperpart2',
            'translation_domain' => 'messages',
        ));

        $builder->add('lowerPart3', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control identity-select'),
            'label'  => 'phased.lowerpart3',
            'translation_domain' => 'messages',
        ));

        $builder->add('upperPart3', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control identity-select'),
            'label'  => 'phased.upperpart3',
            'translation_domain' => 'messages',
        ));

        $builder->add('lowerPart4', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control identity-select'),
            'label'  => 'phased.lowerpart4',
            'translation_domain' => 'messages',
        ));

        $builder->add('upperPart4', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control identity-select'),
            'label'  => 'phased.upperpart4',
            'translation_domain' => 'messages',
        ));

        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn btn-default'),
            'label'  => 'generic.validate',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'phasedParams';
    }
}
