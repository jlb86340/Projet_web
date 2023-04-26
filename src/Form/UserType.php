<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', null,
                [
                    'label' => 'Pseudonyme',
                ]
            )
//            ->add('roles')
            ->add('password',
                null,
            [
             'label' => 'Mot de passe',
            ])
            ->add('name',
                null,
                [
                    'label' => 'Prénom',
                ])
            ->add('surname',
            null,
            [
                'label' => 'Nom de famille',
            ])
            ->add('birthdate',null,
            [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                 'format' => 'yyyy-MM-dd',
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
