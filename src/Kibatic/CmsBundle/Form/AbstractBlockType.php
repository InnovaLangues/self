<?php

namespace Kibatic\CmsBundle\Form;

use Kibatic\CmsBundle\Entity\Block;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractBlockType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('slug', null, [
//                'label_render' => false,
                'attr' => [
                    'placeholder' => 'Slug',
                    'title' => 'Warning : be very carefull when changing the slug as it could break the pages who use this block !'
                ]
            ])
            ->add('content', null, [
//                'label_render' => false,
                'attr' => [
                    'placeholder' => 'Content'
                ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Block::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'kibatic_cmsbundle_block';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
