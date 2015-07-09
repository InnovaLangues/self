<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class GeneralScoreThresholdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('componentType', 'entity', array(
            'class' => 'InnovaSelfBundle:PhasedTest\ComponentType',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')->where('c.name != \'minitest\'')->orderBy('c.name', 'ASC');
            },
            'property' => 'name',
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.threshold.componentType',
            'translation_domain' => 'messages',
        ));

        $builder->add('rightAnswers', 'integer', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.threshold.rightAnswers',
            'translation_domain' => 'messages',
        ));

        $builder->add('level', 'entity', array(
            'class' => 'InnovaSelfBundle:Level',
            'property' => 'name',
            'empty_value' => "-",
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.threshold.level',
            'translation_domain' => 'messages',
        ));

        $builder->add('description', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'phased.threshold.description',
            'translation_domain' => 'messages',
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Innova\SelfBundle\Entity\PhasedTest\GeneralScoreThreshold',
        ));
    }

    public function getName()
    {
        return 'generalScoreThreshold';
    }
}
