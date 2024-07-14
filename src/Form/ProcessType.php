<?php

namespace App\Form;

use App\Entity\client;
use App\Entity\Expertise;
use App\Entity\Process;
use App\Entity\professional;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProcessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', null, [
                'widget' => 'single_text',
            ])
            ->add('endDate', null, [
                'widget' => 'single_text',
            ])
            ->add('Description')
            ->add('client', EntityType::class, [
                'class' => client::class,
                'choice_label' => 'id',
            ])
            ->add('requiredExpertise', EntityType::class, [
                'class' => Expertise::class,
                'choice_label' => 'id',
            ])
            ->add('requiredProfessional', EntityType::class, [
                'class' => professional::class,
                'choice_label' => 'id',
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Process::class,
        ]);
    }
}
