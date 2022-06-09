<?php

namespace App\Form;

use App\Entity\ExpPro;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExpProType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company_name', TextType::class, [
                'label' => 'Nom de l\'entreprise'
            ])
            ->add('job_field', TextType::class, [
                'label' => 'Intitulé du poste'
            ])
            ->add('starting_date', DateType::class, [
                'label' => 'Début',
                'widget' => 'single_text',
            ])
            ->add('ending_date', DateType::class, [
                'label' => 'Fin',
                'widget' => 'single_text',
            ])
            ->add('currently', ChoiceType::class, [
                'label' => 'Emploi acctuel ?',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('job_description', TextareaType::class, [
                'label' => 'Veuillez décrire en quelques lignes vos tâches'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExpPro::class,
        ]);
    }
}
