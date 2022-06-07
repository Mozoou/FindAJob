<?php

namespace App\Controller\Admin;

use App\Entity\SchoolDegree;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SchoolDegreeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SchoolDegree::class;
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
