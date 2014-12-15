<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskInfosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('theme', 'text', array(
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'theme'),
                'label'  => 'editor.identity.theme',
                'translation_domain' => 'messages',
            ));

        $builder->add('fixedOrder', 'choice', array(
                'choices'   => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'fixedOrder'),
                'label'  => 'editor.identity.fixedOrder',
                'translation_domain' => 'messages',
            ));

        $builder->add('skill', 'entity', array(
                'class' => 'InnovaSelfBundle:Skill',
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class' => 'form-control identity-select to-check', 'data-field' => 'skill'),
                'label'  => 'editor.identity.skill',
                'translation_domain' => 'messages',
            ));
    }

    public function getName()
    {
        return 'task_infos';
    }
}
