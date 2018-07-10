<?php

namespace Innova\SelfBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Doctrine\Common\Persistence\ObjectManager;

class UserType extends BaseType
{
    /**
     * @param string $class The User class name
     *                      Go to "RegsitrationFormType" in FriendOfSymfony
     */
    public function __construct($class, ObjectManager $om)
    {
        $this->class = $class;
        $this->om = $om;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     *                                      LevelLansad part : to have an opt group
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('email', 'email')
            ->add('lastName')
            ->add('firstName')
            ->add('institution', 'entity', array(
                    'class' => 'InnovaSelfBundle:Institution\Institution',
                    'query_builder' => function () {
                        return $this->om->getRepository('InnovaSelfBundle:Institution\Institution')->createQueryBuilder('i')->orderBy('i.name', 'ASC');
                    },
                    'required' => true,
                    'empty_value' => 'generic.choose_option',
                ))
            ->add('course', 'entity', array(
                    'class' => 'InnovaSelfBundle:Institution\Course',
                    'required' => true,
                    'empty_value' => 'generic.choose_option',
                    'query_builder' => function () {
                        return $this->om->getRepository('InnovaSelfBundle:Institution\Course')->createQueryBuilder('i')->orderBy('i.name', 'ASC');
                    },
                    'attr' => array('disabled' => 'disabled'),
                ))
            ->add('subcourse', 'entity', array(
                    'label' => 'registration.subcourse',
                    'class' => 'InnovaSelfBundle:Institution\Subcourse',
                    'required' => true,
                    'empty_value' => 'generic.choose_option',
                    'query_builder' => function () {
                        return $this->om->getRepository('InnovaSelfBundle:Institution\Subcourse')->createQueryBuilder('i')->orderBy('i.name', 'ASC');
                    },
                ))
            ->add('year', 'entity', array(
                    'class' => 'InnovaSelfBundle:Institution\Year',
                    'query_builder' => function () {
                        return $this->om->getRepository('InnovaSelfBundle:Institution\Year')->createQueryBuilder('y')->orderBy('y.name', 'ASC');
                    },
                    'property' => 'name',
                    'required' => true,
                    'empty_value' => 'generic.choose_option',
                ))
            ->add('motherTongue', 'text', array(
                    'attr' => array('class' => 'form-control'),
                    'translation_domain' => 'messages',
                ))
            ->add('motherTongueOther', 'text', array(
                    'attr' => array('class' => 'form-control'),
                    'translation_domain' => 'messages',
                ))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Innova\SelfBundle\Entity\User',
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
