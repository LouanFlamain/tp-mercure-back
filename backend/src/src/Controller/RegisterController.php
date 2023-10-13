<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends AbstractController
{
   #[Route('/api/register', 'user.register', methods: "POST")]
   public function register(EntityManagerInterface $manager,Request $req): JsonResponse{
        $data = json_decode($req->getContent(), true);
        $username = $data['username'] ?? null;
        $password = $data["password"] ?? null;
        $verifpassword = $data['verif_password'] ?? null;
        $email = $data["email"] ?? null;

        if(!$email || !$username || !$password){
            return new JsonResponse(array(
                'success' => false,
                'message' => 'not correct fields'
            ), Response::HTTP_BAD_REQUEST);
        }

        if($password !== $verifpassword){
            return new JsonResponse(array(
                'success' => false,
                'message' => 'password incorrect'
            ), Response::HTTP_BAD_REQUEST);
        }

        $user = new User;

        $user
        ->setEmail($email)
        ->setUsername($username)
        ->setPassword($password)
        ->setRoles(array('ROLE_USER'));
        

        $manager->persist($user);
        $manager->flush();

        return new JsonResponse(array(
            'success' => true,
            'message' => 'user created !'
        ), Response::HTTP_OK);

   }
   #[Route('/api/test', "user.test", methods:"GET")]
   public function test(): JsonResponse{
    $response = 'hello world';

    return new JsonResponse(array(
        "response" => $response
    ), Response::HTTP_OK);
   }
}
