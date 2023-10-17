<?php

namespace App\Security;

use App\Entity\People;
use App\Entity\Companies;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AppAuthentificatorAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    private $urlGenerator;
    private $entityManager;

    public function __construct(UrlGeneratorInterface $urlGenerator, EntityManagerInterface $entityManager)
    {
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
    }
    public function supportsRememberMe(): bool
    {
        return true; // Renvoie true pour indiquer que l'authenticator supporte "Remember Me"
    }
    public function authenticate(Request $request): Passport
    {
        $requestData = $request->request->all();

        $email = $requestData["login"]['email'] ?? '';
        $password = $requestData["login"]['password'] ?? '';
        $log = null;

        $user = $this->entityManager->getRepository(People::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $user = $this->entityManager->getRepository(Companies::class)->findOneBy(['contact_email' => $email]);
        }

        if ($user && password_verify($password, $user->getPassword())) {
            $roles = $user->getRoles();
            $log = $this->entityManager->getRepository(People::class)->findOneBy(['password' => $user->getPassword()]);
        } 

        $passport = new Passport(
            new UserBadge($email),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
        // dd($passport);
        return $passport;
    }



    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        $user = $token->getUser();

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return new RedirectResponse($this->urlGenerator->generate('admin'));
        } else if (in_array('ROLE_EMPLOYEUR', $user->getRoles())) {
            return new RedirectResponse($this->urlGenerator->generate('dashboard_company'));
        } else {
            return new RedirectResponse($this->urlGenerator->generate('app_accueil'));
        }
    }


    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
