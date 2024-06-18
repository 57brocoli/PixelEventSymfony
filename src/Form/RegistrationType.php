<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'attr' => [
                    'class' => 'input'
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('username', TextType::class,[
                'attr' => [
                    'class' => 'input'
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('address', TextType::class,[
                'attr' => [
                    'class' => 'input'
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('zipcode', TextType::class,[
                'attr' => [
                    'class' => 'input'
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('city', TextType::class,[
                'attr' => [
                    'class' => 'input'
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe ne correspond pas.',
                'required' => true,
                'first_options' => [
                    'attr' => ['class' => 'input'],
                    'label' => false,
                ],
                'second_options' => [
                    'attr' => ['class' => 'input'],
                    'label' => false,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe.',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Le mot de passe doit faire au moins {{ limit }} caractères.',
                        'max' => 4096,
                    ]),
                ]
            ])
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Pour crée votre compte, vous devez accepter les conditions générales.',
                    ]),
                ],
                'label' => 'J\'accepte les conditions générales d\'utilisation'
            ])
            ->add('newLetter', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'Clicker pour être inscrit à la newletter, et ainsi recevoir par mail toute nos actualitées du moment (facultatif).'
            ])
            ->add('valider', SubmitType::class,[
                'attr' => [
                    'class' => 'submit'
                ],
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
