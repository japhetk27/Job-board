<?php

namespace App\Controller;

use App\Entity\Advertisements;
use App\Entity\Companies;
use App\Entity\EmailBody;
use App\Form\AdType;
use App\Form\EmailBodyFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface; 

class AccueilController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function checkDatabase(): Response
    {
         try {
            $this->entityManager->getConnection()->connect();
            $isConnected = $this->entityManager->getConnection()->isConnected();
        } catch (\Exception $e) {
            $isConnected = false;
        }

        return $this->render('accueil/check_database.html.twig', [
            'isConnected' => $isConnected,
        ]);
    }

    #[Route('/', name: 'app_accueil')]
    public function index(): Response{
        return $this->render('accueil/index.html.twig');
    }

    #[Route('/postuler', name: 'postuler')]

    //ici on la fonction qui 
    public function postuler(Request $request): Response
    {
        $repository = $this->entityManager->getRepository(Advertisements::class);
        $ads = $repository->findAll();
        $companies = [];
        foreach ($ads as $ad) {
            $companies[] = $this->entityManager->getRepository(Companies::class)->findOneBy(['id' => $ad->getCompany()]);
        }

        $données = $request->request->all();
        if ($données) {
            # code...
            $ad = $this->entityManager->getRepository(Advertisements::class)->findOneBy(['id' => $données['email_body_form']['advertisements']]);
            $request->request->set('email_body_form', [
                '_token' => $données['email_body_form']['_token'],
                'advertisements' => $ad,
            ]);
            
        }
        
        $emailBody = new EmailBody;
        $form = $this->createForm(EmailBodyFormType::class, $emailBody, [
            'ad' => $ads,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $emailBody->setDescription($données['email_body_form']['description']);

            $this->entityManager->persist($emailBody); 
            $this->entityManager->flush();

            return $this->redirectToRoute('app_accueil');            

        }
        return $this->render('postuler/index.html.twig', [
            'ads' => $ads,
            'companies' => $companies,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/employeur/dashboard', name: 'dashboard_company')]
    public function dashboardCompany(): Response
    {
        $ad = $this->getUser();
        $ads = $this->entityManager->getRepository(Advertisements::class)->findBy(['company' => $ad->getId()]);

        return $this->render('accueil/dashboard_company.html.twig', [
            'ads' => $ads,
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

    #[Route('/deleteuser', name: 'deleteuser')]
    public function deleteuser(Request $request, Security $security): Response
    {
        $user = $this->getUser();
        
        $security->getUser()->logout();

        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $this->redirectToRoute('accueil');
    }


}
