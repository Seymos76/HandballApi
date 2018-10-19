<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'match_date',
                DateType::class
            )
            ->add(
                'team',
                EntityType::class,
                array(
                    'class' => Team::class,
                    'choice_label' => 'name'
                )
            )
            ->add(
                'opponent',
                TextType::class
            )
            ->add(
                'location',
                TextType::class
            )
            ->add(
                'appointmentLocation',
                TextType::class
            )
            ->add(
                'appointmentDate',
                DateTimeType::class
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
