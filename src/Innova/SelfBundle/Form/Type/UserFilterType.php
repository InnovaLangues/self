<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserFilterType extends AbstractType
{
    const FILTER_ROLE_ALL = 'all';
    const FILTER_ROLE_ADMIN = 'admin';
    const FILTER_ROLE_NOT_ADMIN = 'not-admin';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', 'choice', [
                'label' => 'Role',
                'required' => false,
                'choices' => [
                    self::FILTER_ROLE_ALL => self::FILTER_ROLE_ALL,
                    self::FILTER_ROLE_ADMIN => self::FILTER_ROLE_ADMIN,
                    self::FILTER_ROLE_NOT_ADMIN => self::FILTER_ROLE_NOT_ADMIN
                ],
                'empty_value' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('lastLoginOlderThan', 'date', [
                'label' => 'Dernière connexion avant',
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker form-control',
                    'autocomplete' => 'off'
                ]
            ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false
        ]);
    }

    public function getName()
    {
        return 'filter';
    }
}
