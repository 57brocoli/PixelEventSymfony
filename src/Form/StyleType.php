<?php

namespace App\Form;

use App\Entity\Style;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StyleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $propertyChoices = include __DIR__ . '/Choices/propertyChoice.php';

        $builder
            ->add('property', ChoiceType::class, [
                'label' => 'Propriété',
                'choices' => $propertyChoices,
                'placeholder' => 'Sélectionnez une propriété',
                'attr' => [
                    'class' => 'choise'
                ]
            ])
            ->add('value', TextType::class, [
                'label' => 'Valeur',
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'submit'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Style::class,
        ]);
    }
}
