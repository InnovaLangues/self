<?php

namespace Kibatic\CmsBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class HtmlBlockType extends AbstractBlockType implements BlockTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('content', TextareaType::class, [
            'label_render' => false,
            'attr' => [
                'class' => 'wysiwyg'
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'kibatic_cmsbundle_htmlblock';
    }

    public static function getBlockTypeName(): string
    {
        return 'html';
    }
}
