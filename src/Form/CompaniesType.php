<?php

namespace App\Form;

use App\Entity\Companies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use App\Form\EventSubscriber\CompaniesFormSubscriber;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CompaniesType extends AbstractType
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
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'entreprise',

            ])
            ->add('website', UrlType::class, [
                'label' => 'Website'
            ])
            ->add('siret', NumberType::class, [
                'label' => 'N° Siret',
                'constraints' => [
                    new Length([
                       'min' => 14,
                       'max' => 14,
                       'minMessage' => 'Le siret doit être composé de 14 chiffres',
                       'maxMessage' => 'Le siret doit être composé de 14 chiffres',
                    ])
                ]
            ])
            ->add('logo', FileType::class, [
                'label' => 'Logo de l\'entreprise',
                'data_class' => null,
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
            ->add('is_searching' , ChoiceType::class, [
                'label' => 'Actuellement en recherche de candidat ?',
                'expanded' => true,
                'multiple' => false,
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
                // valeur par défaut
                'data' => false,
            ])
            ->add('searching_for', CollectionType::class, [
                'label' => 'Domaine de recrutement',
                'entry_type' => ChoiceType::class,
                'entry_options'  => [
                    'choices'  => [
                        'Informatique' => 'informatique',
                        'Design' => 'design',
                        'Trasport' => 'trasport',
                        'RH' => 'rh',
                    ],
                ],
                'allow_add' => true,
                'prototype' => true,
            ])
            ->add('phone', NumberType::class, [
                'label' => 'Numéro de téléphone'
            ])
            ->add('fax', NumberType::class, [
                'label' => 'Fax'
            ])
            ->add('linkedin', TextType::class, [
                'label' => 'Linkedin',
            ])
            ->add('searched_region', ChoiceType::class, [
                'label' => 'Region recherchée',
                'choices' => $this->getRegionFromCsv(),
            ])
            ->add('Submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn btn-primary btn-lg'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Companies::class,
        ]);
    }
}
