<?php

namespace Innova\SelfBundle\Form\Type;

use Innova\SelfBundle\Entity\Subquestion;
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

        $builder->add('focuses', 'choice', array(
            'choices' => array_flip(Subquestion::getFocusesValues()),
            'choice_label' => function ($choiceValue) {
                return 'editor.subquestion.focuses.' . $choiceValue;
            },
            'choice_value' => function ($choice = null) {
                return $choice;
            },
            'attr' => [
//                'class' => 'form-control',
//                'size' => count(Subquestion::getFocusesValues())
            ],
            'multiple' => true,
            'expanded' => true,
            'label' => 'editor.subquestion.focuses.label',
            'required' => false,
        ));

        $builder->add('goals', 'choice', [
            'choices' => array_flip(Subquestion::getGoalsValues()),
            'choice_label' => function ($choiceValue) {
                return 'editor.subquestion.goals.' . $choiceValue;
            },
            'choice_value' => function ($choice = null) {
                return $choice;
            },
            'attr' => [
//                'class' => 'form-control',
//                'size' => count(Subquestion::getGoalsValues())
            ],
            'multiple' => true,
            'expanded' => true,
            'label' => 'editor.subquestion.goals.label',
            'required' => false,
        ]);

        $builder->add('redundancy', 'choice', [
            'choices' => array_flip(Subquestion::getRedundancyValues()),
            'choice_label' => function ($choiceValue) {
                return 'editor.subquestion.redundancy.' . $choiceValue;
            },
            'choice_value' => function ($choice = null) {
                return $choice;
            },
            'attr' => ['class' => 'form-control'],
            'label' => 'editor.subquestion.redundancy.label',
            'required' => true
        ]);

        $builder->add('redundancyComment', 'textarea', [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'editor.identity.comment'
            ],
            'label' => false,
            'required' => false
        ]);

        $builder->add('difficultyIndex', 'text', array(
            'attr' => ['class' => 'form-control'],
            'label' => 'editor.subquestion.difficultyIndex',
            'required' => false,
        ));

        $builder->add('discriminationIndex', 'text', array(
            'attr' => ['class' => 'form-control'],
            'label' => 'editor.subquestion.discriminationIndex',
            'required' => false,
        ));

        $builder->add('id', 'hidden', array(
            'mapped' => false,
        ));

        $builder->add('save', 'submit', array(
            'label' => 'generic.save',
            'attr' => ['class' => 'btn btn-default btn-primary'],
        ));
    }

    public function getName()
    {
        return 'subquestion';
    }
}
