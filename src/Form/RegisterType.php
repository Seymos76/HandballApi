<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 05/10/18
 * Time: 23:04
 */

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstname',
                TextType::class
            )
            ->add(
                'lastname',
                TextType::class
            )
            ->add(
                'email',
                EmailType::class
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                array(
                    'type' => PasswordType::class,
                    'required' => true,
                    'first_options' => array('label' => "Entrez votre mot de passe"),
                    'second_options' => array('label' => "Répétez votre mot de passe"),
                    'invalid_message' => "Les deux mots de passe doivent correspondre"
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