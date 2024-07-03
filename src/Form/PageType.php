<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Page;
use App\Entity\Style;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $sites = [
            'Nation Sound' => 'Nation Sound',
            'Pixel Event' => 'Pixel Event',
        ];
        $builder
            ->add('name')
            ->add('styles', EntityType::class, [
                'class' => Style::class,
                'choice_label' => function(Style $style) {
                    return (string) $style; // Utilisation de la méthode __toString() pour l'affichage
                },
                'placeholder' => 'Sélectionnez un style',
                'required'=>false,
                'mapped' => false,
                'multiple' => true,
                'attr' => [
                    'class' => 'entity',
                ],
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'submit'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
