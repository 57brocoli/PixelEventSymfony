<?php

namespace App\Form;

use App\Entity\PageSection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $choices = [
            "Header" => "Header",
            "Section" => "Section",
        ];

        $builder
            ->add('category', ChoiceType::class, [
                'label' => 'Catégorie',
                'choices' => $choices,
                'attr'=> [
                    'class'=>'choise'
                ],
            ])
            ->add('title', TextType::class, [
                'label'=>'Titre'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu'
            ])
            ->add('images', FileType::class, [
                'attr'=> [
                    'class'=>'file'
                ],
                'label'=>'Images',
                'mapped'=>false,
                'multiple'=>true,
                'required'=>false
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
            'data_class' => PageSection::class,
        ]);
    }
}
