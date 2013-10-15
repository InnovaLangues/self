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
            ->add('theme')
            ->add('listeningLimit')
            ->add('dialogue')
            ->add('originText')
            ->add('exerciceText')
            ->add('audioInstruction')
            ->add('audioContext')
            ->add('audioItem')
            ->add('level')
            ->add('sourceType')
            ->add('author')
            ->add('instruction')
            ->add('receptionType')
            ->add('source')
            ->add('duration')
            ->add('domain')
            ->add('functionType')
            ->add('cognitiveOperation')
            ->add('support')
            ->add('flow')
            ->add('focus')
            ->add('languageLevel')
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
