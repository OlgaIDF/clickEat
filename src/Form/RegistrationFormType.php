<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, [
            'attr' => [
                'placeholder' => 'Paul'
            ]
        ])

        ->add('prenom', TextType::class, [
            'attr' => [
                'placeholder' => 'Dupont'
            ]
        ])

        ->add('roles', ChoiceType::class, [
            'choices' => [
                'Utilisateur' => 'ROLE_USER',
                'Serveur' => 'ROLE_SERVEUR',
                'Gerant' => 'ROLE_ADMIN',
                'Administrateur' => 'ROLE_SUPER_ADMIN'
            ],
            'expanded' => true,
            'multiple' => true,
            'label' => 'Rôles' 
        ])
        ->add('telephone', TelType ::class, [
            'attr' => [
                'placeholder' => '01010101'
            ]
        ])

        ->add('adresse', TextType ::class, [
            'attr' => [
                'placeholder' => 'Paris'
            ]
        ])


            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'test.test@mail.com'
                ]
            ])
            
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    
                ],
                'attr' => [
                    'placeholder' => 'mot de passe'
                ],
                'label' => 'Mot de passe'
            ])
            

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions générales d\'utilisation',
                    ]),
                ],
                'label' => 'Accepter les conditions générales d\'utilisation'
            ])

            ->add('Ajouter', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}