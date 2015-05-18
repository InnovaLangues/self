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
