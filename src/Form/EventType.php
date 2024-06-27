<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $cities = [
            'Montpellier' => 'Montpellier',
            'Paris' => 'Paris',
            'Lyon' => 'Lyon',
            
        ];

        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre de l\'evenement'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'evenement'
            ])
            ->add('featuredImage', FileType::class,[
                'attr'=> [
                    'class'=>'file'
                ],
                'label'=>'Image principal',
                'mapped'=>false,
                'multiple'=>false,
                'required'=>false
            ])
            ->add('date', null, [
                'widget' => 'single_text'
            ])
            ->add('city', ChoiceType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => "choise"
                ],
                'choices' => $cities,
            ])
            ->add('Valider', SubmitType::class,[
                'attr' => [
                    'class' => "submit"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
