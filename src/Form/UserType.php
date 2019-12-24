<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder
        ->add('name', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-dark border rounded-0'
            ]
        ])
        ->add('lastName', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-dark border rounded-0'
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-dark border rounded-0'
            ]
        ])
        ->add('username', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-dark border rounded-0'
            ]
        ])
        ->add('state', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-dark border rounded-0'
            ]
        ])
        ->add('city', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-dark border rounded-0'
            ]
        ])
        ->add('post_code', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-dark border rounded-0'
            ]
        ])
        ->add('address', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-dark border rounded-0'
            ]
        ])
        ->add('phone', TextType::class, [
            'label' => false,
            'attr' => [
                'class' => 'form-control border-dark border rounded-0'
            ]
        ])
        ->add('file', FileType::class, [
            'label' => false,
            'required' => false
        ])
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => false,
            'first_options'  => [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-dark border rounded-0'
                ]
            ],
            'second_options' => [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-dark border rounded-0'
                ]
            ]
        ]);
}

public function configureOptions(OptionsResolver $resolver)
{
    $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}