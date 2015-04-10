<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                'attr' => array('class' => 'form-control', 'data-field' => 'name'),
                'label'  => 'group.name',
                'translation_domain' => 'messages',
            ));

        $builder->add('sessions', 'entity', array(
                'class' => 'InnovaSelfBundle:Session',
                'property' => 'name',
                'expanded' => false,
                'multiple' => true,
                'required' => false,
                'attr' => array('class' => 'form-control', 'data-field' => 'session', 'size' => 4),
                'label'  => 'group.sessions',
                'translation_domain' => 'messages',
            ));

        $builder->add('users', 'entity', array(
                'class' => 'InnovaSelfBundle:User',
                'property' => 'username',
                'expanded' => false,
                'multiple' => true,
                'required' => false,
                'attr' => array('class' => 'form-control', 'data-field' => 'user', 'size' => 10),
                'label'  => 'group.users',
                'translation_domain' => 'messages',
            ));

        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn btn-primary'),
            'label'  => 'generic.validate',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'group';
    }
}
