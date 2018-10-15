<?php

namespace App\Form;

use App\Entity\Galery;
use App\Entity\Image;
use App\Form\DataTransformer\MultipleFilesToImagesTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                CollectionType::class,
                array(
                    'entry_type' => EntityType::class,
                    array(
                        'class' => Image::class,
                        'choice_label' => "name"
                    ),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => "Ajoutez vos images"
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Galery::class
        ]);
    }
}
