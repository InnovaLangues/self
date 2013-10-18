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
            ->add('theme', 'text', array('label' => 'questionnaire.field.theme'))
            ->add('listeningLimit', 'integer', array('label' => 'questionnaire.field.listeningLimit'))
            ->add('dialogue', 'checkbox', array('required' => false))
            ->add('audioInstruction', 'text', array('label' => 'questionnaire.field.audioInstruction'))
            ->add('audioContext', 'text', array('label' => 'questionnaire.field.audioContext'))
            ->add('audioItem', 'text', array('label' => 'questionnaire.field.audioItem'))
            ->add('sourceType', null, array('label' => 'questionnaire.field.sourceType'))
            ->add('receptionType', null, array('label' => 'questionnaire.field.receptionType'))
            ->add('functionType', null, array('label' => 'questionnaire.field.functionType'))
            ->add('cognitiveOperation', null, array('label' => 'questionnaire.field.cognitiveOperation'))
            ->add('languageLevel', null, array('label' => 'questionnaire.field.languageLevel'))
            ->add('originText', 'text', array('label' => 'questionnaire.field.originText'))
            ->add('exerciceText', 'text', array('label' => 'questionnaire.field.exerciceText'))
            ->add('level', null, array('label' => 'questionnaire.field.level'))
            ->add('author', null, array('label' => 'questionnaire.field.author'))
            ->add('instruction', null, array('label' => 'questionnaire.field.instruction'))
            ->add('source', null, array('label' => 'questionnaire.field.source'))
            ->add('duration', null, array('label' => 'questionnaire.field.duration'))
            ->add('domain', null, array('label' => 'questionnaire.field.domain'))
            ->add('support', null, array('label' => 'questionnaire.field.support'))
            ->add('flow', null, array('label' => 'questionnaire.field.flow'))
            ->add('focus', null, array('label' => 'questionnaire.field.focus'))
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
