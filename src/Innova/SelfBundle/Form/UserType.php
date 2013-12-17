<?php

namespace Innova\SelfBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Innova\SelfBundle\Entity\LevelLansad;

class UserType extends BaseType
{
    private $levelLansad;

/*
    public function __construct(LevelLansad $level)
    {
        $this->levelLansad = $level->getLevelLansads();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        parent::buildForm($builder, $options);

        $category_choices = array(
            array('English' => array(
                '1' => 'Option 1...',
                '2' => 'Option 2...',
                '3' => 'Option 3...'
            )),
            array('Italian' => array(
                '4' => 'Option 4...',
                '5' => 'Option 5...'
            ))
        );

        $builder
            ->add('lastName')
            ->add('firstName')
            ->add('originStudent')
            ->add(
                'levelLansad',
                'choice',
                array(
                    'label'   => 'Category',
                    'choices' => $category_choices
                )
            )
            ->add('coLevel')
            ->add('ceLevel')
            ->add('eeLevel')
         ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Innova\SelfBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'innova_selfbundle_user';
    }
}
