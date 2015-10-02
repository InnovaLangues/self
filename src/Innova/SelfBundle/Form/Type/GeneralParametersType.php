<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GeneralParametersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('maintenance', 'choice', array(
                'choices'   => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control'),
                'label'  => 'params.maintenance',
                'translation_domain' => 'messages',
            ));

        $builder->add('selfRegistration', 'choice', array(
                'choices'   => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control'),
                'label'  => 'params.selfRegistration',
                'translation_domain' => 'messages',
            ));

        $builder->add('save', 'submit', array(
                'label' => 'generic.save',
                'attr' => array('class' => 'btn btn-default btn-primary'),
            ));
    }

    public function getName()
    {
        return 'group';
    }
}
