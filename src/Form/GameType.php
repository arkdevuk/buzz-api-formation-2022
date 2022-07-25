<?php

namespace App\Form;

use App\Entity\GameGenre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Titre du jeu',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Description du jeu 🐒',
                ],
            ])
            ->add('attachement', FileType::class, [
                'mapped' => false,
                'multiple' => true,
                'label' => 'Image(s)',
                'required' => false,
                'attr' => [
                    'accept' => 'image/*',
                    'multiple' => 'multiple',
                    'class' => 'pomme-maccaque',
                    'placeholder' => 'Image du jeu',
                ],
            ])
            ->add('platforms', ChoiceType::class, [
                'choices' => [
                    'PC' => 'PC',
                    'PS4' => 'PS4',
                    'PS5' => 'PS5',
                    'XBOX360' => 'XBOX360',
                    'XBOX ONE' => 'XBOX ONE',
                    'SWITCH' => 'SWITCH'
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('type', EntityType::class, [
                'label' => 'Type',
                'required' => true,
                'multiple' => true,
                'class' => GameGenre::class,
                'choice_label' => 'name',
                'attr' => [
                    'placeholder' => 'Type du jeu',
                ],
            ])
            ->add('dateRelease', DateTimeType::class, [
                'label' => 'Date de sortie',
                'required' => false,
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'placeholder' => 'Date de sortie',
                ],
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'required' => true,
                'attr' => [
                    'min' => 0,
                    'placeholder' => '19,99',
                ],
            ])
            ->add('promotion', NumberType::class, [
                'label' => 'Promotion (en %)',
                'required' => false,
                'attr' => [
                    'max' => 100,
                    'min' => 0,
                    'placeholder' => '19,99',
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => '➕ Ajouter le jeu',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ]);
    }
}