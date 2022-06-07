<?php

namespace App\Form;

use App\Entity\ExpPro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company_name')
            ->add('starting_date')
            ->add('currently')
            ->add('ending_date')
            ->add('job_field')
            ->add('job_description')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExpPro::class,
        ]);
    }
}
