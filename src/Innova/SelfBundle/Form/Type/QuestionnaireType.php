<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            $builder ->add('level', 'entity', array(
                'class' => 'InnovaSelfBundle:Level', 
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class'=>'form-control identity-select','data-field'=>'level'),
                'label'  => 'level',
                'translation_domain' => 'messages',
            ));

            $builder ->add('language', 'entity', array(
                'class' => 'InnovaSelfBundle:Language', 
                'property' => 'name',
                'attr' => array('class'=>'form-control identity-select','data-field'=>'language'),
                'label'  => 'language',
                'translation_domain' => 'messages',
            ));

            $builder ->add('status', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Status', 
                'property' => 'name',
                'attr' => array('class'=>'form-control identity-select','data-field'=>'status'),
                'label'  => 'status',
                'translation_domain' => 'messages',
            ));

            $builder ->add('levelProof', 'textarea', array(
                'attr' => array('class'=>'form-control identity-select','data-field'=>'levelProof'),
                'label'  => 'level.proof',
                'translation_domain' => 'messages'
            ));

           $builder ->add('authorRight', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\AuthorRight', 
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class'=>'form-control identity-select','data-field'=>'authorRight'),
                'label'  => 'author.right',
                'translation_domain' => 'messages',
            ));

           $builder ->add('authorRightMore', 'textarea', array(
                'attr' => array('class'=>'form-control identity-select','data-field'=>'authorRightMore'),
                'label'  => 'author.right.more',
                'translation_domain' => 'messages'
            ));

           $builder ->add('source', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Source', 
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class'=>'form-control identity-select','data-field'=>'source'),
                'label'  => 'source',
                'translation_domain' => 'messages'
            ));

           $builder ->add('sourceMore', 'textarea', array(
                'attr' => array('class'=>'form-control identity-select','data-field'=>'sourceMore'),
                'label'  => 'source.more',
                'translation_domain' => 'messages'
            ));

           $builder ->add('sourceOperation', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\SourceOperation', 
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class'=>'form-control identity-select','data-field'=>'sourceOperation'),
                'label'  => 'source.operation',
                'translation_domain' => 'messages'
            ));

           $builder ->add('domain', 'entity',  array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Domain', 
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class'=>'form-control identity-select','data-field'=>'domain'),
                'label'  => 'domain',
                'translation_domain' => 'messages'
            ));

           $builder ->add('register', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Register', 
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class'=>'form-control identity-select','data-field'=>'register'),
                'label'  => 'register',
                'translation_domain' => 'messages'
            ));

           $builder ->add('reception', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Reception', 
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class'=>'form-control identity-select','data-field'=>'reception'),
                'label'  => 'reception',
                'translation_domain' => 'messages'
            ));

           $builder ->add('length', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Length', 
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class'=>'form-control identity-select','data-field'=>'length'),
                'label'  => 'length',
                'translation_domain' => 'messages'
            ));

           $builder ->add('flow', 'entity', array(
                'class' => 'InnovaSelfBundle:QuestionnaireIdentity\Flow', 
                'property' => 'name',
                'empty_value' => "-",
                'attr' => array('class'=>'form-control identity-select','data-field'=>'flow'),
                'label'  => 'flow',
                'translation_domain' => 'messages'
            ));
    }

    public function getName()
    {
        return 'questionnaire';
    }
}