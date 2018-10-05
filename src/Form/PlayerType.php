<?php

namespace App\Form;

use App\Entity\Player;
use App\Entity\Team;
use App\Form\DataTransformer\FileToImageTransformer;
use App\Manager\ImageManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    private $imageManager;
    private $session;
    private $transformer;

    public function __construct(ImageManager $imageManager, SessionInterface $session, FileToImageTransformer $transformer)
    {
        $this->imageManager = $imageManager;
        $this->session = $session;
        $this->transformer = $transformer;
    }

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
                'position',
                ChoiceType::class,
                array(
                    'choices' => array(
                        "Centre arrière" => "center_back",
                        "Gardien de but" => "goad_keeper",
                        "Arrière gauche" => "left_back",
                        "Arrière droit" => "right_back",
                        "Ailier gauche" => "left_wing",
                        "Ailier droit" => "right_wing",
                        "Demi-centre" => "pivot"
                    ),
                    'expanded' => false
                )
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
                'image',
                FileType::class
            )
            ->get('image')->addModelTransformer($this->transformer)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
