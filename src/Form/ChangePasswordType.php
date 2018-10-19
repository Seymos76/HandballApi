<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 09/10/18
 * Time: 17:31
 */

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'plainPassword',
                RepeatedType::class,
                array(
                    'type' => PasswordType::class,
                    'first_options' => ['label' => "Nouveau mot de passe"],
                    'second_options' => ['label' => "Répétez le nouveau mot de passe"],
                    'invalid_message' => "Les deux mots de passe ne correspondent pas"
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => User::class
            )
        );
    }
}
