<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Colour;
use App\Entity\Gender;
use App\Entity\Material;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', EntityType::class, [
                'label' => 'Select gender:',
                'placeholder' => 'choose...',
                'class' => Gender::class,
                'choice_label' => 'name',
                'choice_value' => function (Gender $entity = null) {
                    return $entity ? $entity->getName() : '';
                },
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => 'Select category:',
                'placeholder' => 'choose...',
                'class' => Category::class,
                'choice_label' => 'name',
                'choice_value' => function (Category $entity = null) {
                    return $entity ? $entity->getName() : '';
                },
                'choice_attr' => function(Category $entity = null) {
                    return ['name' => $entity->getId()];
                },
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('colour', EntityType::class, [
                'label' => 'Select colour:',
                'class' => Colour::class,
                'choice_label' => 'name',
                'choice_value' => function (Colour $entity = null) {
                    return $entity ? $entity->getName() : '';
                },
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('brand', EntityType::class, [
                'label' => 'Select brand:',
                'class' => Brand::class,
                'choice_label' => 'name',
                'choice_value' => function (Brand $entity = null) {
                    return $entity ? $entity->getName() : '';
                },
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('material', EntityType::class, [
                'label' => 'Select material:',
                'class' => Material::class,
                'choice_label' => 'name',
                'choice_value' => function (Material $entity = null) {
                    return $entity ? $entity->getName() : '';
                },
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Enter price:',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Product description'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Submit',
                'attr' => [
                    'class' => 'btn btn-success btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
