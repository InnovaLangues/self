<?php

namespace Innova\SelfBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class YearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                'attr' => array('class' => 'form-control', 'data-field' => 'name'),
                'label'  => 'year.name',
                'translation_domain' => 'messages',
            ));

        $builder->add('save', 'submit', array(
                'label' => 'generic.save',
                'attr' => array('class' => 'btn btn-default btn-primary'),
            ));
    }

    public function getName()
    {
        return 'year';
    }
}
