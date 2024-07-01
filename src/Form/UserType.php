<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('username', TextType::class, [
                'label' => 'Pseudo'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('zipcode', TextType::class,[
                'attr' => [
                    'class' => 'input'
                ],
                'label' => 'Code postal',
                'required' => true,
            ])
            ->add('city', TextType::class,[
                'attr' => [
                    'class' => 'input'
                ],
                'label' => 'Ville',
                'required' => true,
            ])
            ->add('isSubscriber', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Clicker pour être inscrit à la newletter, et ainsi recevoir par mail toute nos actualitées du moment (facultatif).'
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
            'data_class' => User::class,
        ]);
    }
}
