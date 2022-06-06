<?php

namespace App\Controller\Admin;

use App\Entity\Companies;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompaniesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Companies::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
