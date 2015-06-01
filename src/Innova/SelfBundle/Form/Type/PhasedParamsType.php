<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PhasedParamsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('thresholdToStep2', 'integer', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.step2Threshold',
            'translation_domain' => 'messages',
        ));

        $builder->add('thresholdToStep3', 'integer', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.step3Threshold',
            'translation_domain' => 'messages',
        ));

        $builder->add('thresholdToStep2Leveled', 'integer', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.step2ThresholdLeveled',
            'translation_domain' => 'messages',
        ));

        $builder->add('thresholdToStep2Level', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control identity-select'),
            'label'  => 'phased.thresholdToStep2Level',
            'translation_domain' => 'messages',
        ));

        $builder->add('thresholdToStep3Leveled', 'integer', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.step3ThresholdLeveled',
            'translation_domain' => 'messages',
        ));

        $builder->add('thresholdToStep3Level', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control identity-select'),
            'label'  => 'phased.thresholdToStep3Level',
            'translation_domain' => 'messages',
        ));

        $builder->add('generalScoreThresholds', 'collection', array(
            'type' => new GeneralScoreThresholdType(),
            'allow_add' => true,
            'allow_delete' => true,
            'mapped' => true,
            'by_reference' => false,
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
