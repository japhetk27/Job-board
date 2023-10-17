<?php

namespace App\Controller\Admin;

use App\Entity\Advertisements;
use App\Repository\CompaniesRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdvertisementsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Advertisements::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('company', 'Company')
                ->setFormTypeOption('query_builder', function (CompaniesRepository $CompaniesRepository) {
                    return $CompaniesRepository->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                })
                ->setRequired(true), 
            TextField::new('title'),
            TextEditorField::new('description'),
            DateField::new('posted_date'),
            DateField::new('expiration_date'),
            NumberField::new('salary'),
            TextField::new('location'),
            TextField::new('work_schedule'),
            TextEditorField::new('resume'),
        ];
    }
    
}
