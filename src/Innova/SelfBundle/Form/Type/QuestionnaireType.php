<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('authorMore', 'textarea', array(
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'authorMore'),
                'label'  => 'editor.identity.authorMore',
                'translation_domain' => 'messages',
            ));

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

        $builder->add('level', 'entity', array(
                'class' => 'InnovaSelfBundle:Level',
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'level'),
                'label'  => 'editor.identity.level',
                'translation_domain' => 'messages',
            ));

        $builder->add('language', 'entity', array(
                'class' => 'InnovaSelfBundle:Language',
                'property' => 'name',
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'language'),
                'label'  => 'editor.identity.language',
                'translation_domain' => 'messages',
            ));

        $builder->add('status', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Status',
                'property' => 'name',
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'status'),
                'label'  => 'editor.identity.status',
                'translation_domain' => 'messages',
            ));

        $builder->add('levelProof', 'textarea', array(
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'levelProof'),
                'label'  => 'editor.identity.level.proof',
                'translation_domain' => 'messages',
            ));

        $builder->add('authorRight', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\AuthorRight',
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'authorRight'),
                'label'  => 'editor.identity.author.right',
                'translation_domain' => 'messages',
            ));

        $builder->add('authorRightMore', 'textarea', array(
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'authorRightMore'),
                'label'  => 'editor.identity.author.right.more',
                'translation_domain' => 'messages',
            ));

        $builder->add('source', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Source',
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'source'),
                'label'  => 'editor.identity.source',
                'translation_domain' => 'messages',
            ));

        $builder->add('sourceMore', 'textarea', array(
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'sourceMore'),
                'label'  => 'editor.identity.source.more',
                'translation_domain' => 'messages',
            ));

        $builder->add('sourceOperation', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\SourceOperation',
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'sourceOperation'),
                'label'  => 'editor.identity.source.operation',
                'translation_domain' => 'messages',
            ));

        $builder->add('domain', 'entity',  array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Domain',
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'domain'),
                'label'  => 'editor.identity.domain',
                'translation_domain' => 'messages',
            ));

        $builder->add('register', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Register',
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'register'),
                'label'  => 'editor.identity.register',
                'translation_domain' => 'messages',
            ));

        $builder->add('reception', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Reception',
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'reception'),
                'label'  => 'editor.identity.reception',
                'translation_domain' => 'messages',
            ));

        $builder->add('length', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Length',
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'length'),
                'label'  => 'editor.identity.length',
                'translation_domain' => 'messages',
            ));

        $builder->add('flow', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Flow',
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class' => 'form-control identity-select', 'data-field' => 'flow'),
                'label'  => 'editor.identity.flow',
                'translation_domain' => 'messages',
            ));

         $builder->add('save', 'submit', array(
                'label' => 'generic.save',
                'attr' => array('class' => 'btn btn-default btn-primary'),
            ));
    }

    public function getName()
    {
        return 'questionnaire';
    }
}
