<?php

namespace Innova\SelfBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionnaireType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level')
            ->add('source')
            ->add('supportType')
            ->add('typology')
            ->add('focus')
            ->add('cognitiveOperation')
            ->add('function')
            ->add('receptionType')
            ->add('domain')
            ->add('genre')
            ->add('sourceType')
            ->add('languageLevel')
            ->add('durationGroup')
            ->add('flow')
            ->add('wordCount')
            ->add('theme')
            ->add('author')
            ->add('consigne')
            ->add('audioConsigne')
            ->add('audioContexte')
            ->add('audioItem')
            ->add('tests')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Innova\SelfBundle\Entity\Questionnaire'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'innova_selfbundle_questionnaire';
    }
}
