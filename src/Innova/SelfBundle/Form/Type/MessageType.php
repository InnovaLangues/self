<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'message.content',
            'translation_domain' => 'messages',
        ));

        $builder->add('channel', 'choice', array(
            'choices'   => array('all' => 'A tous', 'admin' => 'Aux admins uniquement', 'user' => 'A un utilisateur'),
            'label'  => 'message.channel',
            'attr' => array('class' => 'form-control'),
            'translation_domain' => 'messages',
        ));

        $builder->add('user', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label'  => 'message.user',
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
        return 'message';
    }
}
