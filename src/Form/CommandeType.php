<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Commandes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('reference', TextType::class)
            // ->add('date', DateType::class)
            // // ->add('menus',  TextType::class)
            ->add('valider', CheckboxType::class, array(
                'required' => false,
                'value' => 1,
            ))
           /*  ->add('total', MoneyType::class)
            ->add('utilisateur', EntityType::class, array(
                'class'=>User::class,
                'choice_label'=>'nom',
            ))*/
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ]
            ) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commandes::class,
        ]);
    }
}
