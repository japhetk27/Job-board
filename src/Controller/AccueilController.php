<?php

namespace App\Controller;

use App\Entity\Advertisements;
use App\Entity\Companies;
use App\Entity\EmailBody;
use App\Form\EmailBodyFormType;
use App\Form\UserUpdateType;
use App\Form\CompaniesUpdateType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
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
            $emailBody->setPerson($this->getUser());

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

    #[Route('/deleteuser', name: 'deleteuser')]
    public function deleteuser(Request $request, TokenStorageInterface $tokenStorage): Response
    {
        $user = $this->getUser();
        $tokenStorage->setToken(null);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $this->redirectToRoute('accueil');
    }

    #[Route('/updateuser', name: 'updateuser')]
    public function updateuser(Request $request): Response
    {
        $user = $this->getUser();
    
        if ($user instanceof \App\Entity\People) {
            $form = $this->createForm(UserUpdateType::class, $user, [
                'user' => $user,
            ]);
            $route = 'app_accueil';
        } elseif ($user instanceof \App\Entity\Companies) {
            $form = $this->createForm(CompaniesUpdateType::class, $user, [
                'user' => $user,
            ]);
            $route = 'dashboard_company';
        }        

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute($route);            

        }
        return $this->render('accueil/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
