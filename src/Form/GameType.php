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
                'team',
                EntityType::class,
                array(
                    'class' => Team::class,
                    'choice_label' => 'name',
                    'label' => "L'équipe qui va jouer"
                )
            )
            ->add(
                'opponent',
                TextType::class,
                array(
                    'label' => "L'équipe adverse"
                )
            )
            ->add(
                'location',
                TextType::class,
                array(
                    'label' => "Le lieu du match"
                )
            )
            ->add(
                'appointmentLocation',
                TextType::class,
                array(
                    'label' => "Le lieu du rendez-vous"
                )
            )
            ->add(
                'appointmentDate',
                DateTimeType::class,
                array(
                    'label' => "La date et l'heure du rendez-vous"
                )
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
