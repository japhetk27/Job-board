<?php

namespace App\Controller\Admin;

use App\Entity\Companies;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompaniesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Companies::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('industry'),
            TextField::new('location'),
            TextField::new('contact_email'),
            TextField::new('password'),
        ];
    }
    
}
