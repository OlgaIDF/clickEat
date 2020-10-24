<?php

namespace App\Form;

use App\Entity\Restaurants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titre', TextType::class, [
            'required' => true,
            'label' => 'Nom du restaurant',
            'attr' => [
                'placeholder' => 'Resto1'
            ]
        ]
        )
        ->add('titre', TextType::class, [
            'required' => true,
            'label' => 'Description',
            'attr' => [
                'placeholder' => 'Trônant au cœur de la coulée verte, TheGodfather est « the place to be » si vous voulez vivre une expérience gourmande dans un cadre rétro tendance'
            ]
        ]
        )
            ->add('img_resto',TextType::class, [
                'required' => true,
                'label' => 'Photo du restaurant',
                'attr' => [
                    'placeholder' => 'image.jpg'
                ]
            ]
            )
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurants::class,
        ]);
    }
}
