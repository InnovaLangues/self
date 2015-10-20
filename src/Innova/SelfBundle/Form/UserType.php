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
            ->add('originStudent', 'entity', array(
                    'class'   => 'InnovaSelfBundle:OriginStudent',
                    'query_builder' => function () {
                        return $this->om->getRepository('InnovaSelfBundle:OriginStudent')->createQueryBuilder('o')->orderBy('o.name', 'ASC');
                    },
                    'required' => true,
                    'empty_value' => 'Choisissez une option',
                ))
            ->add('levelLansad', 'entity',
                array(
                    'label'   => 'Category',
                    'class'   => 'InnovaSelfBundle:LevelLansad',
                    'choices' => $this->getArrayOfLevelLansad(),
                )
            )
            ->add('testDialang', 'choice',
                    array(
                    'choices' => array('Oui' => 'Oui', 'Non' => 'Non'),
                    'required' => true,
                    'multiple' => false,
                    'mapped' => false,
                ))
            ->add('coLevel')
            ->add('ceLevel')
            ->add('eeLevel')

            ->add('institution', 'entity', array(
                    'class'   => 'InnovaSelfBundle:Institution\Institution',
                    'query_builder' => function () {
                        return $this->om->getRepository('InnovaSelfBundle:Institution\Institution')->createQueryBuilder('i')->orderBy('i.name', 'ASC');
                    },
                    'required' => true,
                    'empty_value' => 'Choisissez une option'
                ))

            ->add('course', 'entity', array(
                    'class'   => 'InnovaSelfBundle:Institution\Course',
                    'required' => true,
                    'empty_value' => 'Choisissez une option',
                    'query_builder' => function () {
                        return $this->om->getRepository('InnovaSelfBundle:Institution\Course')->createQueryBuilder('i')->orderBy('i.name', 'ASC');
                    },
                    'attr' => array("disabled" => "disabled")
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

    /**
     * @return array
     *               Request to have all skills for all languages
     */
    private function getArrayOfLevelLansad()
    {
        // Tab declaration
        $list = array();

        // To have all Language
        $languages = $this->om->getRepository('InnovaSelfBundle:Language')->findAll();

        foreach ($languages as $language) {
            $levelLansads = $language->getLevelLansads();
            if (count($levelLansads)>0) {
                $list[$language->getName()] = array();
                foreach ($levelLansads as $levelLansad) {
                    $list[$language->getName()][$levelLansad->getName()] = $levelLansad;
                }
            }
        }

        return $list;
    }
}
