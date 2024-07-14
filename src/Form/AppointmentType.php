<?php

namespace App\Form;

use App\Entity\Appointment;
use App\Entity\professional;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateIn', null, [
                'widget' => 'single_text',
            ])
            ->add('timeIn', null, [
                'widget' => 'single_text',
            ])
            ->add('duration')
            ->add('given_Professional', EntityType::class, [
                'class' => professional::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
