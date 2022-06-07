<?php

namespace App\Controller\Admin;

use App\Entity\Candidat;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class CandidatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidat::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            BooleanField::new('is_searching'),
            ImageField::new('profile_picture')
                ->setBasePath('uploads/images/')
                ->setUploadDir('public/uploads/images/'),
            DateField::new('date_birth'),
            // ChoiceField::new('formations')->setChoices([
            //     'Informatique' => 'informatique',
            //     'Graphisme' => 'graphisme',
            //     'Livreur' => 'livreur',
            //     'Chauffeur' => 'chauffeur',
            //     'Agent de sécurité' => 'Agent de sécurité'
            // ]),
            ChoiceField::new('studies_level')->setChoices([
                'BAC' => '1',
                'BAC+2' => '2',
                'BAC+3' => '3',
                'BAC+4' => '4',
                'BAC+5' => '5'
            ]),
            ChoiceField::new('pro_exp')->setChoices([
                '> à 1 an' => '1',
                'entre 2 ans et 5 ans' => '2',
                '+ de 5 ans' => '3'
            ]),
            CollectionField::new('hard_skills'),
            CollectionField::new('soft_skills'),
            TextField::new('linkdin')->setFormTypeOption('disabled','disabled'),
            TextField::new('searched_region')->setFormTypeOption('disabled','disabled'),

        ];
    }
    
}
