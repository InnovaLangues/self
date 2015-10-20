<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('lastname', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'user.name',
            'translation_domain' => 'messages',
        ));

        $builder->add('firstname', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'user.firstname',
            'translation_domain' => 'messages',
        ));

        $builder->add('preferedLanguage', 'entity', array(
            'class'   => 'InnovaSelfBundle:Language',
            'label'  => 'user.preferedLanguage',
            'empty_value' => "-",
            'required' => false,
        ));

        $builder->add('save', 'submit', array(
            'label'  => 'generic.save',
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
