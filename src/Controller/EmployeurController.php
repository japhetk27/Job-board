<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Advertisements;
use App\Entity\Companies;
use App\Entity\EmailBody;
use App\Form\AdType;
use App\Form\updateFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class EmployeurController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/employeur/dashboard', name: 'dashboard_company')]
    public function dashboardCompany(): Response
    {
        $ad = $this->getUser();
        $ads = $this->entityManager->getRepository(Advertisements::class)->findBy(['company' => $ad->getId()]);

        $count = [];
        foreach ($ads as $ad) {
            $count[] = count($this->entityManager->getRepository(EmailBody::class)->findBy(['advertisements' => $ad->getId()]));
        }
        return $this->render('accueil/dashboard_company.html.twig', [
            'ads' => $ads,
            'count' => $count,
        ]);
    }


    #[Route('/employeur/ad', name: 'ad')]
    public function ad(Request $request): Response{

        $advertisement = new Advertisements();

        // Récupérer toutes les entreprises
    
        $companies = $this->entityManager->getRepository(Companies::class)->createQueryBuilder('c')
            ->where('c.id >= :company_Id')
            ->setParameter('company_Id', 3)
            ->getQuery()
            ->getResult();

        $form = $this->createForm(AdType::class, $advertisement, [
            'companies' => $companies,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer la date actuelle
            $dateActuelle = new \DateTime();
            $datemodifier = new \DateTime();
            $advertisement->setPostedDate($dateActuelle);

            // Ajouter 2 mois
            $datemodifier->modify('+2 months');

            // Attribuer la nouvelle date à expirationDate
            $advertisement->setExpirationDate($datemodifier);
            $ad = $this->getUser();
            $advertisement->setCompany($ad);

            $this->entityManager->persist($advertisement); // Persistez l'annonce dans la base de données
            $this->entityManager->flush();

            // Redirigez vers la page d'accueil ou une autre page appropriée
            return $this->redirectToRoute('dashboard_company');
        }

        return $this->render('accueil/ads.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    #[Route('/employeur/ad/{id}', name: 'editad')]
    public function editad(Request $request, int $id) : Response
    {

        $info = $this->entityManager->getRepository(Advertisements::class)->find($id);
        // Vérifie si l'ad est bien à l'entreprise
        if ($info->getCompany() != $this->getUser()) {
            return $this->redirectToRoute('dashboard_company');
        }
        $companies = $this->entityManager->getRepository(Companies::class)->findOneBy(['id' => $info->getCompany()]);
        
        $form = $this->createForm(updateFormType::class, $info, [
            'companies' => $companies,
            'info' => $info,
        ]);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer la date actuelle
            $dateActuelle = new \DateTime();
            $datemodifier = new \DateTime();
            $info->setPostedDate($dateActuelle);

            // Ajouter 2 mois
            $datemodifier->modify('+2 months');

            // Attribuer la nouvelle date à expirationDate
            $info->setExpirationDate($datemodifier);

            $this->entityManager->flush();

            // Redirigez vers la page d'accueil ou une autre page appropriée
            return $this->redirectToRoute('dashboard_company');
        }
        return $this->render('accueil/ads.html.twig', 
        [
            'form' => $form->createView(),
            'info' => $info,
        ]);
    }

    #[Route('/employeur/seeapplicants/{id}', name: 'seeapplicants')]
    public function seeapplicants(Request $request, int $id) : Response
    {
        $info = $this->entityManager->getRepository(Advertisements::class)->find($id);
        // Vérifie si l'ad est bien à l'entreprise
        if ($info->getCompany() != $this->getUser()) {
            return $this->redirectToRoute('dashboard_company');
        }
        $applicants = $this->entityManager->getRepository(EmailBody::class)->findBy(['advertisements' => $info->getId()]);
        return $this->render('accueil/seeapplicants.html.twig', 
        [
            'applicants' => $applicants,
            'info' => $info,
        ]);
    }

    #[Route('/employeur/ad/deletead/{id}', name: 'deletead')]
    public function deletead(Request $request, int $id) : Response
    {
        $info = $this->entityManager->getRepository(Advertisements::class)->find($id);
        // Vérifie si l'ad est bien à l'entreprise
        if ($info->getCompany() != $this->getUser()) {
            return $this->redirectToRoute('dashboard_company');
        }
        $this->entityManager->remove($info);
        $this->entityManager->flush();
        return $this->redirectToRoute('dashboard_company');
    }
}
