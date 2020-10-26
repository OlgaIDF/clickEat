<?php

namespace App\Form;

use App\Entity\Menus;
use App\Entity\Restaurants;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => 'Nom du menu',
                'attr' => [
                    'placeholder' => 'menu1'
                ]
            ]
            )
            ->add('composants', TextType::class, [
                'required' => true,
                'label' => 'Composants',
                'attr' => [
                    'placeholder' => 'Liste de composants'
                ]
            ]
            )
            ->add('img_menu', FileType::class, [
                'required' => true,
                'mapped' => false,
                'label' => 'Photo du menu',
                'attr' => [
                    'placeholder' => 'image.jpg'
                ]
            ]
            )
            ->add('prix',  MoneyType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'ex.: 99,00',
                    'min' => 0
                ]
            ])
            ->add('restaurant', EntityType::class, array(
                'class'=>Restaurants::class,
                'choice_label'=>'id',
            )
                
            )
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ]
            )
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menus::class,
        ]);
    }
}
