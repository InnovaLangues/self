<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SubquestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('level', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => '-',
            'attr' => array('class' => 'form-control identity-select'),
            'label' => 'editor.subquestion.level',
            'translation_domain' => 'messages',
        ));

        $builder->add('focuses', 'entity', array(
            'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Focus',
            'property' => 'name',
            'attr' => array('class' => 'form-control subquestion-identity-field', 'data-field' => 'focuses', 'size' => 3),
            'multiple' => true,
            'label' => 'editor.subquestion.focuses',
            'translation_domain' => 'messages',
            'required' => false,
            'choice_translation_domain' => 'messages',
        ));

        $builder->add('cognitiveOpsMain', 'entity', array(
            'class' => 'InnovaSelfBundle:QuestionnaireIdentity\CognitiveOperation',
            'property' => 'name',
            'attr' => array('class' => 'form-control subquestion-identity-field', 'data-field' => 'cognitiveOpsMain', 'size' => 7),
            'multiple' => true,
            'label' => 'editor.subquestion.cognitive_main',
            'translation_domain' => 'messages',
            'required' => false,
            'choice_translation_domain' => 'messages',
        ));

        $builder->add('difficultyIndex', 'text', array(
            'attr' => array('class' => 'form-control subquestion-identity-field'),
            'label' => 'editor.subquestion.difficultyIndex',
        ));

        $builder->add('difficultyIndex', 'text', array(
            'attr' => array('class' => 'form-control subquestion-identity-field'),
            'label' => 'editor.subquestion.redundancy',
            'required' => false,
        ));

        $builder->add('discriminationIndex', 'text', array(
            'attr' => array('class' => 'form-control subquestion-identity-field'),
            'label' => 'editor.subquestion.discriminationIndex',
            'required' => false,
        ));

        $builder->add('id', 'hidden', array(
            'mapped' => false,
        ));

        $builder->add('save', 'submit', array(
            'label' => 'generic.save',
            'attr' => array('class' => 'btn btn-default btn-primary'),
        ));
    }

    public function getName()
    {
        return 'subquestion';
    }
}
