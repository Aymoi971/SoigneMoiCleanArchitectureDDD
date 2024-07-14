<?php

namespace App\Form;

use App\Entity\client;
use App\Entity\Professional;
use App\Entity\Rights;
use App\Entity\Roles;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('Address')
            ->add('ZipCode')
            ->add('Country')
            ->add('professional', EntityType::class, [
                'class' => Professional::class,
                'choice_label' => 'id',
            ])
            ->add('individualRights', EntityType::class, [
                'class' => Rights::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('businessRole', EntityType::class, [
                'class' => Roles::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('client', EntityType::class, [
                'class' => client::class,
                'choice_label' => 'id',
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
