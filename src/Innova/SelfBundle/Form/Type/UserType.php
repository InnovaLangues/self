<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function __construct($em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastname', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'user.name',
            'translation_domain' => 'messages',
        ))

        ->add('firstname', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'user.firstname',
            'translation_domain' => 'messages',
        ))

        ->add('preferedLanguage', 'entity', array(
            'class' => 'InnovaSelfBundle:Language',
            'label' => 'user.preferedLanguage',
            'empty_value' => '-',
            'required' => false,
        ))

        ->add('institution', 'entity', array(
            'label' => 'registration.institution',
            'class' => 'InnovaSelfBundle:Institution\Institution',
            'query_builder' => function () {
                return $this->em->getRepository('InnovaSelfBundle:Institution\Institution')->createQueryBuilder('i')->orderBy('i.name', 'ASC');
            },
            'required' => true,
            'empty_value' => 'generic.choose_option',
        ))

        ->add('course', 'entity', array(
            'label' => 'registration.course',
            'class' => 'InnovaSelfBundle:Institution\Course',
            'required' => true,
            'empty_value' => 'generic.choose_option',
            'query_builder' => function () {
                return $this->em->getRepository('InnovaSelfBundle:Institution\Course')->createQueryBuilder('i')->orderBy('i.name', 'ASC');
            },
        ))

        ->add('subcourse', 'entity', array(
            'label' => 'registration.subcourse',
            'class' => 'InnovaSelfBundle:Institution\Subcourse',
            'required' => true,
            'empty_value' => 'generic.choose_option',
            'query_builder' => function () {
                return $this->em->getRepository('InnovaSelfBundle:Institution\Subcourse')->createQueryBuilder('i')->orderBy('i.name', 'ASC');
            },
        ))

        ->add('year', 'entity', array(
            'label' => 'registration.year',
            'class' => 'InnovaSelfBundle:Institution\Year',
            'query_builder' => function () {
                return $this->em->getRepository('InnovaSelfBundle:Institution\Year')->createQueryBuilder('y')->orderBy('y.name', 'ASC');
            },
            'property' => 'name',
            'required' => true,
            'empty_value' => 'generic.choose_option',
        ))

        ->add('motherTongue', 'text', array(
            'attr' => array('class' => 'form-control', 'required' => false),
            'label' => 'user.motherTongue',
            'translation_domain' => 'messages',
            'required' => false,
        ))

        ->add('motherTongueOther', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'user.motherTongueOther',
            'translation_domain' => 'messages',
            'required' => false,
        ))

        ->add('save', 'submit', array(
            'label' => 'generic.save',
        ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'user_type';
    }
}
