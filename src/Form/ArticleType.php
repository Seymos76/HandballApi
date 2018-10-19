<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Gallery;
use App\Form\DataTransformer\ArticleFileToArrayTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    private $transformer;

    public function __construct(ArticleFileToArrayTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class
            )
            ->add(
                'summary',
                TextareaType::class,
                array(
                    'required' => false
                )
            )
            ->add(
                'content',
                TextareaType::class
            )
            ->add(
                'gallery',
                EntityType::class,
                array(
                    'class' => Gallery::class,
                    'choice_label' => 'name',
                    'required' => false
                )
            )
            ->add(
                'image',
                ImageType::class,
                array(
                    'data_class' => null,
                    'required' => false,
                )
            )
            ->get('image')->addModelTransformer($this->transformer)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
