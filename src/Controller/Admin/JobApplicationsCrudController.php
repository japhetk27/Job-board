<?php

namespace App\Controller\Admin;

use App\Entity\JobApplications;
use App\Repository\AdvertisementsRepository;
use App\Repository\EmailBodyRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class JobApplicationsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobApplications::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('ad', 'Advertisements')
                ->setFormTypeOption('query_builder', function (AdvertisementsRepository $AdvertisementsRepository) {
                    return $AdvertisementsRepository->createQueryBuilder('a')
                        ->orderBy('a.title', 'ASC');
                })
                ->setRequired(true),
            AssociationField::new('email_body', 'Demandeur')
                ->setFormTypeOption('query_builder', function (EmailBodyRepository $EmailBodyRepository) {
                    return $EmailBodyRepository->createQueryBuilder('em')
                        ->orderBy('em.person', 'ASC');
                })
                ->setRequired(true),
            DateField::new('application_date'),
            TextField::new('status'),
            BooleanField::new('email_sent'),
        ];
    }
    
}
