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
            ],
            'label' => 'editor.identity.levelProof',
            'translation_domain' => 'messages',
            'required' => false
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

//            'required' => false,
        ));

        $builder->add('language', 'entity', array(
            'class' => 'InnovaSelfBundle:Language',
            'property' => 'name',
            'attr' => array('class' => 'form-control identity-select', 'data-field' => 'language'),
            'label' => 'editor.identity.language',
        ));

        $builder->add('sourceTypes', 'entity', [
            'class' => 'InnovaSelfBundle:QuestionnaireIdentity\SourceType',
            'property' => 'name',
            'attr' => [
                'class' => '',
                'data-field' => 'sourceTypes'
            ],
            'label' => 'editor.identity.sourceTypes',
            'translation_domain' => 'messages',
            'multiple' => true,
            'required' => true,
            'expanded' => true,
        ]);

        $builder->add('length', 'entity', [
            'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Length',
            'property' => 'name',
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
            'label' => 'editor.identity.readability',
            'attr' => [
                'class' => 'form-control identity-select',
                'data-field' => 'readability'
            ],
            'required' => false
        ]);

        $builder->add('flow', 'entity', [
            'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Flow',
            'multiple' => true,
            'property' => 'name',
            'empty_value' => '-',
            'attr' => [
                'class' => 'form-control identity-select',
                'data-field' => 'flow'
            ],
            'label' => 'editor.identity.flow',
            'choice_translation_domain' => true,
            'required' => false
        ]);

        $builder->add('comment', 'textarea', [
            'label' => 'editor.identity.comment',
            'attr' => [
                'class' => 'form-control identity-select',
                'data-field' => 'comment'
            ],
            'required' => false
        ]);

        $builder->add('context', 'textarea', [
            'label' => 'editor.identity.context',
            'attr' => [
                'class' => 'form-control identity-select',
                'data-field' => 'context'
            ],
            'required' => false
        ]);

        $builder->add('textType', 'textarea', [
            'attr' => [
                'class' => 'form-control identity-select',
                'data-field' => 'speechType'
            ],
            'label' => 'editor.identity.textType',
            'required' => false
        ]);

        $builder->add('register', 'entity', [
            'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Register',
            'property' => 'name',
            'empty_value' => '-',
            'attr' => [
                'class' => 'form-control identity-select',
                'data-field' => 'register'
            ],
            'label' => 'editor.identity.register',
            'choice_translation_domain' => true,
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
                1 => 'editor.identity.speakers.1',
                2 => 'editor.identity.speakers.2',
                3 => 'editor.identity.speakers.3',
                4 => 'editor.identity.speakers.4',
            ],
            'label' => 'editor.identity.speakers.label',
            'required' => false
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

        $builder->add('authorizationRequestedAt', 'date', [
            'label' => 'editor.identity.authorizationRequestedAt',
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control',
            ],
        ]);

        $builder->add('authorizationGrantedAt', 'date', [
            'label' => 'editor.identity.authorizationGrantedAt',
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control',
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
