<?php

namespace App\Form;

use App\Entity\Artiste;
use App\Entity\Day;
use App\Entity\Episode;
use App\Entity\Lieu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('datetime', TimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('artiste', EntityType::class, [
                'attr' => [
                    'class' => 'choise'
                ],
                'required' => false,
                'label' => false,
                'class' => Artiste::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un artiste',
                // 'constraints' => [
                //     new NotBlank([
                //         'message' => 'Veuillez sélectionner un artiste',
                //     ]),
                // ],
            ])
            ->add('lieu', EntityType::class, [
                'attr' => [
                    'class' => 'choise'
                ],
                'required' => false,
                'label' => false,
                'class' => Lieu::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez un lieu',
            ])
            ->add('Valider', SubmitType::class,[
                'attr' => [
                    'class' => 'submit'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
