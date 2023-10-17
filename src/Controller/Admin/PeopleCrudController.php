<?php

namespace App\Controller\Admin;

use App\Entity\People;
use App\Repository\CompaniesRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\config\Action;

class PeopleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return People::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('first_name'),
            TextField::new('name'),
            TextField::new('email'),
            TextField::new('phone_number'),
            TextField::new('password'),
        ];
    }
    
}
