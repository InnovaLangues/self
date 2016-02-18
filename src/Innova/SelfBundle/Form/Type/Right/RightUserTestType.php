<?php

namespace Innova\SelfBundle\Form\Type\Right;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class RightUserTestType extends AbstractType
{
    public function __construct($em, $rightUserTest)
    {
        $this->em = $em;
        $this->rightUserTest = $rightUserTest;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$this->rightUserTest->getId()) {
            $builder->add('user', 'entity', array(
                'choices' => array(),
                'class' => 'InnovaSelfBundle:User',
                'attr' => array('class' => 'form-control', 'data-field' => 'user'),
                'label' => 'user.single',
                'translation_domain' => 'messages',
            ));
        } else {
            $userId = $this->rightUserTest->getUser()->getId();
            $builder->add('user', 'entity', array(
                'class' => 'InnovaSelfBundle:User',
                'query_builder' => function () use ($userId) {
                    $query = $this->em->getRepository('InnovaSelfBundle:User')->createQueryBuilder('u')
                                    ->where('u.id = :id')
                                    ->setParameter('id', $userId);

                    return $query;
                },
                'attr' => array('class' => 'form-control', 'data-field' => 'user'),
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

        $builder->add('canDuplicate', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canDuplicate'),
                'label' => 'canDuplicate',
                'translation_domain' => 'messages',
            ));

        $builder->add('canManageSession', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canManageSession'),
                'label' => 'canManageSession',
                'translation_domain' => 'messages',
            ));

        $builder->add('canManageTask', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canManageTask'),
                'label' => 'canManageTask',
                'translation_domain' => 'messages',
            ));

        $builder->add('canAddTask', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canAddTask'),
                'label' => 'canAddTask',
                'translation_domain' => 'messages',
            ));

        $builder->add('canDeleteTask', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canDeleteTask'),
                'label' => 'canDeleteTask',
                'translation_domain' => 'messages',
            ));

        $builder->add('canEditTask', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canEditTask'),
                'label' => 'canEditTask',
                'translation_domain' => 'messages',
            ));

        $builder->add('canReorderTasks', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canReorderTasks'),
                'label' => 'canReorderTasks',
                'translation_domain' => 'messages',
            ));

        $builder->add('canEditorReadOnlyTasks', 'choice', array(
                'choices' => array('0' => 'generic.no', '1' => 'generic.yes'),
                'attr' => array('class' => 'form-control', 'data-field' => 'canEditorReadOnlyTasks'),
                'label' => 'canEditorReadOnlyTasks',
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
        return 'right_user_test';
    }
}
