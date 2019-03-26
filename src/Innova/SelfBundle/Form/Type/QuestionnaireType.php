<?php

namespace Innova\SelfBundle\Form\Type;

use Innova\SelfBundle\Entity\Questionnaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden', array('mapped' => false));

        $builder->add('status', 'entity', array(
            'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Status',
            'property' => 'name',
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'editor.identity.status',
        ));


        $builder->add('levelProof', 'textarea', [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'editor.identity.levelProof.placeholder',
                'rows' => 4
            ],
            'label' => 'editor.identity.levelProof.label',
            'translation_domain' => 'messages',
            'required' => false,
        ]);

        $builder->add('authorMore', 'textarea', [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'editor.identity.authorMore',
            'required' => false
        ]);

        $builder->add('authorRight', 'choice', array(
            'choices' => array_flip(Questionnaire::getAuthorRightValues()),
            'choice_label' => function ($choiceValue, $key, $value) {
                return 'editor.identity.authorRight.' . $choiceValue;
            },
            'choice_value' => function ($choice = null) {
                return $choice;
            },
            'attr' => [
            ],
            'choice_attr' => [
                'class' => 'checkbox-inline'
            ],
            'label' => 'editor.identity.authorRight.label',
            'expanded' => true,
        ));

        $builder->add('sourceTypes', 'entity', [
            'class' => 'InnovaSelfBundle:QuestionnaireIdentity\SourceType',
            'property' => 'name',
            'attr' => [
                'data-field' => 'sourceTypes'
            ],
            'choice_attr' => [
                'class' => 'checkbox-inline'
            ],
            'label' => 'editor.identity.sourceTypes',
            'translation_domain' => 'messages',
            'multiple' => true,
            'required' => true,
            'expanded' => true,
        ]);

        $builder->add('length', 'choice', [
            'choices' => array_flip(Questionnaire::getLengthValues()),
            'choice_label' => function ($choiceValue, $key, $value) {
                return 'length.' . $choiceValue;
            },
            'choice_value' => function ($choice = null) {
                return $choice;
            },
            'empty_value' => '-',
            'attr' => [
                'class' => 'form-control identity-select',
                'data-field' => 'length'
            ],
            'label' => 'editor.identity.length',
            'choice_translation_domain' => true,
            'required' => false
        ]);

        $builder->add('readability', 'textarea', [
            'label' => 'editor.identity.readability.label',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'editor.identity.readability.placeholder'
            ],
            'required' => false
        ]);

        $builder->add('flow', 'choice', [
            'choices' => array_flip(Questionnaire::getFlowValues()),
            'choice_label' => function ($choiceValue, $key, $value) {
                return 'flow.' . $choiceValue;
            },
            'choice_value' => function ($choice = null) {
                return $choice;
            },
            'multiple' => true,
            'empty_value' => '-',
            'attr' => [
                'class' => 'form-control',
                'data-field' => 'flow',
                'size' => count(Questionnaire::getFlowValues())
            ],
            'label' => 'editor.identity.flow',
            'choice_translation_domain' => true,
            'required' => false
        ]);

        $builder->add('flowComment', 'textarea', [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'editor.identity.comment'
            ],
            'label' => false,
            'required' => false
        ]);

        $builder->add('context', 'textarea', [
            'label' => 'editor.identity.context.label',
            'attr' => [
                'class' => 'form-control identity-select',
                'data-field' => 'context',
                'placeholder' => 'editor.identity.context.placeholder'
            ],
            'required' => false
        ]);

        $builder->add('textType', 'textarea', [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'editor.identity.textType.placeholder'
            ],
            'label' => 'editor.identity.textType.label',
            'required' => false
        ]);

        $builder->add('register', 'choice', [
            'choices' => array_flip(Questionnaire::getRegisterValues()),
            'choice_label' => function ($choiceValue, $key, $value) {
                return 'register.' . $choiceValue;
            },
            'choice_value' => function ($choice = null) {
                return $choice;
            },
            'empty_value' => '-',
            'attr' => [
                'class' => 'form-control',
                'size' => count(Questionnaire::getRegisterValues())
            ],
            'label' => 'editor.identity.register',
            'choice_translation_domain' => true,
            'required' => false,
            'multiple' => true,
        ]);

        $builder->add('variety', 'textarea', [
            'label' => 'editor.identity.variety.label',
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'editor.identity.variety.placeholder'
            ],
            'required' => false
        ]);

        $builder->add('genres', 'entity', [
            'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Genre',
            'property' => 'name',
            'attr' => [
                'class' => '',
                'data-field' => 'genres',
                'size' => 4
            ],
            'label' => 'editor.identity.speechType',
            'translation_domain' => 'messages',
            'multiple' => true,
            'expanded' => true,
            'required' => true
        ]);

        $builder->add('speakers', 'choice', [
            'attr' => [
                'class' => 'form-control',
            ],
            'choices' => [
                0 => 'editor.identity.speakers.0',
                1 => 'editor.identity.speakers.1',
                2 => 'editor.identity.speakers.2',
                3 => 'editor.identity.speakers.3',
                4 => 'editor.identity.speakers.4',
            ],
            'preferred_choices' => [1],
            'label' => 'editor.identity.speakers.label',
        ]);

        $builder->add('createdBySelf', null, [
            'required' => false,
            'attr' => [
                'class' => 'identity-select',
            ],
            'label_attr' => [
                'class' => 'checkbox-inline'
            ],
            'label' => 'editor.identity.createdBySelf',
        ]);

        $builder->add('freeLicence', null, [
            'required' => false,
            'label_attr' => [
                'class' => 'checkbox-inline'
            ],
            'label' => 'editor.identity.freeLicence',
        ]);

        $builder->add('freeLicenceComment', 'textarea', [
            'attr' => [
                'class' => 'form-control',
                'placeholder' => 'editor.identity.freeLicenceComment'
            ],
            'label' => false,
            'required' => false
        ]);

        $builder->add('authorizationRequestedAt', 'date', [
            'label' => 'editor.identity.authorizationRequestedAt',
            'years' => range(date('Y') - 10, date('Y') + 10),
//            'widget' => 'single_text',
            'widget' => 'choice',
            'attr' => [
//                'class' => 'form-control',
            ],
        ]);

        $builder->add('authorizationGrantedAt', 'date', [
            'label' => 'editor.identity.authorizationGrantedAt',
//            'widget' => 'single_text',
            'widget' => 'choice',
            'attr' => [
//                'class' => 'form-control',
            ],
        ]);

        $builder->add('sourceUrl', 'textarea', [
            'required' => false,
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'editor.identity.sourceUrl',
        ]);

        $builder->add('sourceStorage', 'textarea', [
            'required' => false,
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'editor.identity.sourceStorage',
        ]);

        $builder->add('sourceContacts', 'textarea', [
            'required' => false,
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'editor.identity.sourceContacts',
        ]);
    }

    public function getName()
    {
        return 'questionnaire';
    }
}
