<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private $JWTManager;

    public function __construct(JWTTokenManagerInterface $JWTManager)
    {
        $this->JWTManager = $JWTManager;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        /** @var UserInterface $user */
        $user = $token->getUser();
        $jwtToken = $this->JWTManager->create($user);

        $response = new JsonResponse([
            'token' => $jwtToken,
            'success' => true
        ]);


        $cookie = new Cookie(
            'BEARER',
            $jwtToken,
            //3600
        );

        $cookie2 = new Cookie(
            'BEARER',              // Nom du cookie
            $jwtToken,             // Valeur du cookie
            3600,                  // tps
            '/',                   // chemin
            null,                  // domaine
            false,                 // sécurisé
            true,                  // httpOnly
            false,  
            null               // pour URL-encoder la valeur du cookie, pas nécessaire ici
            //Cookie::SAMESITE_NONE  // SameSite 
        );
    $response->headers->setCookie($cookie);
    //$response->headers->set('Set-Cookie', "BEARER=".$jwtToken);

        return $response;
    }
}
