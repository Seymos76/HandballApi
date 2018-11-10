<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstname',
                TextType::class,
                array(
                    'label' => "Prénom"
                )
            )
            ->add(
                'lastname',
                TextType::class,
                array(
                    'label' => "NOM"
                )
            )
            ->add(
                'email',
                EmailType::class,
                array(
                    'label' => "E-mail"
                )
            )
            ->add(
                'password',
                RepeatedType::class,
                array(
                    'type' => PasswordType::class,
                    'first_options' => ['label' => "Nouveau mot de passe"],
                    'second_options' => ['label' => "Répétez le nouveau mot de passe"],
                    'invalid_message' => "Les deux mots de passe ne correspondent pas"
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
