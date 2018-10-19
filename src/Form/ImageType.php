<?php

namespace App\Form;

use App\Entity\Image;
use App\Form\DataTransformer\FileToImageTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    private $transformer;

    public function __construct(FileToImageTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'filename',
                FileType::class
            )
            ->add(
                'title',
                TextType::class,
                array(
                    'label' => "Titre de l'image (optionnel)",
                    'required' => false
                )
            )
            ->add(
                'description',
                TextareaType::class,
                array(
                    'label' => "Description de l'image (optionnel)",
                    'required' => false
                )
            )
            ->add(
                'size',
                HiddenType::class
            )
            ->add(
                'mimeType',
                HiddenType::class
            )
            //->get('filename')->addModelTransformer($this->transformer)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
