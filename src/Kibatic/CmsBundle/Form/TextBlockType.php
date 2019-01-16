<?php

namespace Kibatic\CmsBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class TextBlockType extends AbstractBlockType implements BlockTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('content', new TextareaType(), [
//            'label_render' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'kibatic_cmsbundle_textblock';
    }

    public static function getBlockTypeName(): string
    {
        return 'text';
    }
}
