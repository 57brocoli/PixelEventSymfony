<?php

namespace App\Form;

use App\Entity\Lieu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Nom du lieu'
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description du lieu'
            ])
            ->add('category', ChoiceType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'choise'
                ],
                'placeholder' => 'Catégorie',
                'choices' => [
                    'Scene' => 'Scene',
                    'Bar' => 'Bar'
                ]
            ])
            ->add('gpsLat', NumberType::class,[
                'scale' => 5,
                'label' => 'Coordonnées GPS Latitude',
                'required' => false
            ])
            ->add('gpsLng', NumberType::class,[
                'scale' => 5,
                'label' => 'Coordonnées GPS Longitude',
                'required' => false
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
            'data_class' => Lieu::class,
        ]);
    }
}
