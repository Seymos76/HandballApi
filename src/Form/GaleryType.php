<?php

namespace App\Form;

use App\Entity\Galery;
use App\Form\DataTransformer\MultipleFilesToImagesTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GaleryType extends AbstractType
{
    private $transformer;

    public function __construct(MultipleFilesToImagesTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class
            )
            ->add(
                'images',
                FileType::class,
                array(
                    'multiple' => true
                )
            )
            ->get('images')->addModelTransformer($this->transformer)
            ->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'))
            ->addEventListener(FormEvents::SUBMIT, array($this, 'onSubmit'))
            ->addEventListener(FormEvents::POST_SUBMIT, array($this, 'onPostSubmit'))
        ;
    }

    public function onPreSubmit(FormEvent $event)
    {
        dump($event->getData());
    }

    public function onSubmit(FormEvent $event)
    {
        dump($event->getData());
    }

    public function onPostSubmit(FormEvent $event)
    {
        dump($event->getData());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Galery::class
        ]);
    }
}
