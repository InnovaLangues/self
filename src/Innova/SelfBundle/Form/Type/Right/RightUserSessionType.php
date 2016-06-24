<?php

namespace Innova\SelfBundle\Form\Type\Right;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RightUserSessionType extends AbstractType
{
    public function __construct($em, $rightUserSession)
    {
        $this->em = $em;
        $this->rightUserSession = $rightUserSession;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$this->rightUserSession->getId()) {
            $builder->add('user', 'entity', array(
                'choices' => array(),
                'class' => 'InnovaSelfBundle:User',
                'attr' => array('class' => 'form-control', 'data-field' => 'user', 'required' => true),
                'label' => 'user.single',
                'translation_domain' => 'messages',
            ));
        } else {
            $userId = $this->rightUserSession->getUser()->getId();
            $builder->add('user', 'entity', array(
                'class' => 'InnovaSelfBundle:User',
                'query_builder' => function () use ($userId) {
                $query = $this->em->getRepository('InnovaSelfBundle:User')->createQueryBuilder('u')
                                ->where('u.id = :id')
                                ->setParameter('id', $userId);

                return $query;
                },
                'attr' => array('class' => 'form-control', 'data-field' => 'user', 'required' => true),
                'label' => 'user.single',
                'translation_domain' => 'messages',
            ));
        }

        $builder->add('canEdit', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canEdit'),
                'label' => 'canEdit',
                'translation_domain' => 'messages',
            ));

        $builder->add('canDelete', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canDelete'),
                'label' => 'canDelete',
                'translation_domain' => 'messages',
            ));

        $builder->add('canExportIndividual', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canExportIndividual'),
                'label' => 'canExportIndividual',
                'translation_domain' => 'messages',
            ));

        $builder->add('canDeleteTrace', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canDeleteTrace'),
                'label' => 'canDeleteTrace',
                'translation_domain' => 'messages',
            ));

        $builder->add('canExportCollective', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canExportCollective'),
                'label' => 'canExportCollective',
                'translation_domain' => 'messages',
            ));

        $builder->add('save', 'submit', array(
                'label' => 'generic.save',
                'attr' => array('class' => 'btn btn-default btn-primary'),
            ));

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            $formOptions = array(
                'class' => 'InnovaSelfBundle:User',
                'property' => 'username',
                'query_builder' => function () use ($data) {
                    $query = $this->em->getRepository('InnovaSelfBundle:User')->createQueryBuilder('u')
                                    ->where('u.id = :id')
                                    ->setParameter('id', $data['user']);

                    return $query;
                },
            );
            $form->add('user', 'entity', $formOptions);
        });
    }

    public function getName()
    {
        return 'right_user_session';
    }
}
