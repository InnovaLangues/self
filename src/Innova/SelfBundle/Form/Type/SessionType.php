<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'editor.session.name',
            'translation_domain' => 'messages',
        ));

        $builder->add('passwd', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'editor.session.code',
            'translation_domain' => 'messages',
        ));

        $builder->add('actif', 'choice', array(
            'choices'   => array(false => 'generic.no', true => 'generic.yes'),
            'label'  => 'editor.session.active',
            'attr' => array('class' => 'form-control'),
            'translation_domain' => 'messages',
        ));

        $builder->add('globalScoreShow', 'choice', array(
            'choices'   => array(false => 'generic.no', true => 'generic.yes'),
            'label'  => 'editor.session.globalScoreShow',
            'attr' => array('class' => 'form-control'),
            'translation_domain' => 'messages',
        ));

        $builder->add('globalScoreWording', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'editor.session.globalScoreWording',
            'translation_domain' => 'messages',
        ));

        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn btn-default'),
            'label'  => 'generic.validate',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'session';
    }
}
