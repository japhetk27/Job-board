<?php

namespace App\Controller\Admin;

use App\Entity\EmailBody;
use App\Repository\AdvertisementsRepository;
use App\Repository\PeopleRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EmailBodyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EmailBody::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('person', 'Person')
                ->setFormTypeOption('query_builder', function (PeopleRepository $PeopleRepository) {
                return $PeopleRepository->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC');
                })
                ->setRequired(true),
            TextEditorField::new('description'),
            AssociationField::new('advertisements', 'Advertisements')
                ->setFormTypeOption('query_builder', function (AdvertisementsRepository $AdvertisementsRepository) {
                return $AdvertisementsRepository->createQueryBuilder('a')
                        ->orderBy('a.title', 'ASC');
                })
                ->setRequired(true), 
        ];
    }
    
}
