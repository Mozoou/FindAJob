<?php

namespace App\Form;

use App\Entity\Formations;
use App\Entity\SchoolDegree;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('starting_date', DateType::class,[
                'label' => 'Début',
                'widget' => 'single_text',
            ])
            ->add('ending_date', DateType::class,[
                'label' => 'Fin',
                'widget' => 'single_text',
            ])
            ->add('currently', ChoiceType::class, [
                'label' => 'Formation acctuelle ?',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('school_degree', EntityType::class, [
                'class' => SchoolDegree::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'level',
            ])
            ->add('industry', ChoiceType::class, [
                'label' => 'Domaine',
                'expanded' => false,
                'multiple' => false,
                'choices'  => [
                    'Informatique' => 'informatique',
                    'Design' => 'design',
                    'Trasport' => 'transport',
                    'Marketing' => 'marketing',
                    'Medical' => 'medical',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formations::class,
        ]);
    }
}
