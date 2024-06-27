<?php

namespace App\Form;

use App\Entity\Day;
use App\Entity\Programme;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('date', null, [
                'widget' => 'single_text'
            ])
            // ->add('programme', EntityType::class, [
            //     'class' => Programme::class,
            //     'choice_label' => 'id',
            // ])
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
            'data_class' => Day::class,
        ]);
    }
}
