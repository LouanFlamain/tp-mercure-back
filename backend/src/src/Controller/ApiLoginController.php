<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class ApiLoginController extends AbstractController
  {

    private $JWTManager;

    public function __construct(JWTTokenManagerInterface $JWTManager)
    {
        $this->JWTManager = $JWTManager;
    }

    #[Route('/api/login', name: 'api_login')]
     public function index(#[CurrentUser] ?User $user)
      {
         /*if (null === $user) {
             return $this->json([
                 'message' => 'missing credentials',
             ], Response::HTTP_UNAUTHORIZED);
         }

         $token = $this->JWTManager->create($user);

         //implémenter api token

          return $this->json([
             'message' => 'Welcome to your new controller!',
             'path' => 'src/Controller/ApiLoginController.php',
             'user'  => $user->getUserIdentifier(),
             'role' => $user->getRoles(),
             'password' => $user->getPassword(),
             'email' => $user->getEmail(),
             'token' => $token

             //'token' => $token,
          ]);*/
      }
  }
