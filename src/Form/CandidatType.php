<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CandidatType extends AbstractType
{
    protected $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }
    public function getRegionFromCsv()
    {
        $path = $this->parameterBag->get('kernel.project_dir');
        $regions = [];
        $row = 2;
        if (($handle = fopen($path . '/public/csv/departements-region.csv', 'r')) !== FALSE) {
            fgetcsv($handle, 10000, ",");
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                $row++;
                array_pop($data);

                $regions[$data[0].' - '.$data[1]] = $data[0];
            }
            fclose($handle);
            return ($regions);
        }
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('is_searching', ChoiceType::class, [
                'label' => 'Actuellement en recherche d\'emploi ?',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('profile_picture', FileType::class, [
                'label' => 'Photo de profil',
                'constraints' => [
                    new File([
                        'maxSize' => '2000k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir un format d\'image valide',
                    ])
                ],
            ])
            ->add('date_birth', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => ['class' => 'myDatePickerInput'],
            ])
            ->add('formations', ChoiceType::class, [
                'label' => 'Domaine d\'études',
                'choices'  => [
                    'Informatique' => 'informatique',
                    'Graphisme' => 'graphisme',
                    'Livreur' => 'livreur',
                    'Chauffeur' => 'chauffeur',
                    'Agent de sécurité' => 'Agent de sécurité'
                ],
            ])
            ->add('studies_level', ChoiceType::class, [
                'label' => 'Niveau d\'études',
                'choices'  => [
                    'BAC' => '1',
                    'BAC+2' => '2',
                    'BAC+3' => '3',
                    'BAC+4' => '4',
                    'BAC+5' => '5'
                ],
            ])
            ->add('pro_exp', ChoiceType::class, [
                'label' => 'Expériance professionnelle',
                'choices' => [
                    '> à 1 an' => '1',
                    'entre 2 ans et 5 ans' => '2',
                    '+ de 5 ans' => '3'
                ]
            ])
            ->add('hard_skills', CollectionType::class, [
                'label' => 'Hard Skills',
                'entry_type' => TextType::class,
                'allow_add' => true,
                'prototype' => true,
                'prototype_data' => '',
            ])
            ->add('soft_skills', CollectionType::class, [
                'label' => 'Soft Skills',
                'entry_type' => TextType::class,
                'allow_add' => true,
                'prototype' => true,
                'prototype_data' => '',
            ])
            ->add('linkdin', TextType::class, [
                'attr' => ['aria-describedby' => 'basic-addon3'],
            ])
            ->add('searched_region', ChoiceType::class, [
                'label' => 'Region',
                'choices' => $this->getRegionFromCsv(),
            ])

            ->add('Submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
