<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\PageSection;
use App\Entity\Style;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        $propertyChoices = [
            'Box Model' => [
                'Width' => 'width',
                'Height' => 'height',
                'Margin' => 'margin',
                'Padding' => 'padding',
                'Border' => 'border',
                'Border Radius' => 'border-radius',
                'Box Sizing' => 'box-sizing',
            ],
            'Typography' => [
                'Font Family' => 'font-family',
                'Font Size' => 'font-size',
                'Font Weight' => 'font-weight',
                'Font Style' => 'font-style',
                'Line Height' => 'line-height',
                'Text Align' => 'text-align',
                'Text Decoration' => 'text-decoration',
                'Text Transform' => 'text-transform',
                'Letter Spacing' => 'letter-spacing',
                'Color' => 'color',
            ],
            'Background' => [
                'Background' => 'background',
                'Background Color' => 'background-color',
                'Background Image' => 'background-image',
                'Background Repeat' => 'background-repeat',
                'Background Position' => 'background-position',
                'Background Size' => 'background-size',
            ],
            'Positioning' => [
                'Position' => 'position',
                'Top' => 'top',
                'Right' => 'right',
                'Bottom' => 'bottom',
                'Left' => 'left',
                'Z-Index' => 'z-index',
            ],
            'Flexbox' => [
                'Display' => 'display',
                'Flex Direction' => 'flex-direction',
                'Justify Content' => 'justify-content',
                'Align Items' => 'align-items',
                'Align Self' => 'align-self',
                'Flex Wrap' => 'flex-wrap',
                'Flex Grow' => 'flex-grow',
                'Flex Shrink' => 'flex-shrink',
                'Flex Basis' => 'flex-basis',
                'Order' => 'order',
            ],
            'Grid' => [
                'Grid Template Columns' => 'grid-template-columns',
                'Grid Template Rows' => 'grid-template-rows',
                'Grid Template Areas' => 'grid-template-areas',
                'Grid Column' => 'grid-column',
                'Grid Row' => 'grid-row',
                'Grid Area' => 'grid-area',
                'Gap' => 'gap',
                'Justify Items' => 'justify-items',
                'Align Items' => 'align-items',
            ],
            'Display & Visibility' => [
                'Display' => 'display',
                'Visibility' => 'visibility',
                'Overflow' => 'overflow',
                'Overflow X' => 'overflow-x',
                'Overflow Y' => 'overflow-y',
            ],
            'Colors and Opacity' => [
                'Color' => 'color',
                'Background Color' => 'background-color',
                'Border Color' => 'border-color',
                'Opacity' => 'opacity',
            ],
            'Animations and Transitions' => [
                'Transition' => 'transition',
                'Transition Property' => 'transition-property',
                'Transition Duration' => 'transition-duration',
                'Transition Timing Function' => 'transition-timing-function',
                'Transition Delay' => 'transition-delay',
                'Animation' => 'animation',
                'Animation Name' => 'animation-name',
                'Animation Duration' => 'animation-duration',
                'Animation Timing Function' => 'animation-timing-function',
                'Animation Delay' => 'animation-delay',
                'Animation Iteration Count' => 'animation-iteration-count',
                'Animation Direction' => 'animation-direction',
            ],
            'Miscellaneous' => [
                'Cursor' => 'cursor',
                'Box Shadow' => 'box-shadow',
                'Text Shadow' => 'text-shadow',
                'Outline' => 'outline',
                'Outline Offset' => 'outline-offset',
            ],
        ];
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
