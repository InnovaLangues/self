<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CourseEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'course.name',
            'translation_domain' => 'messages',
        ));

        $builder->add('subcourses', 'collection', array(
            'type' => new SubcourseType(),
            'label' => 'course.subcourses',
            'allow_add' => true,
            'allow_delete' => true,
            'mapped' => true,
            'by_reference' => false,
        ));

        $builder->add('save', 'submit', array(
            'attr' => array('class' => 'btn btn-default'),
            'label' => 'generic.validate',
            'translation_domain' => 'messages',
        ));
    }

    public function getName()
    {
        return 'course_edit';
    }
}
