<?php

namespace App\Controller;

use App\Entity\People;
use App\Entity\Companies;
use App\Form\UserType;
use App\Form\LoginType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PeopleRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function register(EntityManagerInterface $entityManager, Request $request){
        $user = new People();
        $form = $this->createForm(UserType::class, $user);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
    
            return $this->redirectToRoute('accueil');
        }
    
        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('accueil'); // Redirige si l'utilisateur est déjà connecté
        }

        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }

    
    public function logout(Security $security)
    {
        // logout the user in on the current firewall
        $response = $security->logout();

        // you can also disable the csrf logout
        $response = $security->logout(false);

    }
}
