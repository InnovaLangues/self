<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                'attr' => array('class' => 'form-control', 'data-field' => 'name'),
                'label'  => 'name',
                'translation_domain' => 'messages',
            ));

        $builder->add('language', 'entity', array(
                'class' => 'InnovaSelfBundle:Language',
                'property' => 'name',
                'attr' => array('class' => 'form-control', 'data-field' => 'language'),
                'label'  => 'language',
                'translation_domain' => 'messages',
            ));

        $builder->add('phased', 'choice', array(
                'choices'   => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'phased'),
                'label'  => 'phased',
                'translation_domain' => 'messages',
            ));

        $builder->add('archived', 'choice', array(
                'choices'   => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'archived'),
                'label'  => 'archived',
                'translation_domain' => 'messages',
            ));

        $builder->add('save', 'submit', array(
                'label' => 'generic.save',
                'attr' => array('class' => 'btn btn-default btn-primary'),
            ));
    }

    public function getName()
    {
        return 'test';
    }
}
