<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\jsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends AbstractController
{
   #[Route('/api/register', 'user.register', methods: "POST")]
   public function register(EntityManagerInterface $manager,Request $req): jsonResponse{
        $data = json_decode($req->getContent(), true);
        $username = $data['username'] ?? null;
        $password = $data["password"] ?? null;
        $verifpassword = $data['verif_password'] ?? null;
        $email = $data["email"] ?? null;

        if(!$email || !$username || !$password){
            return new jsonResponse(array(
                'success' => false,
                'message' => 'not correct fields'
            ), Response::HTTP_BAD_REQUEST);
        }

        if($password !== $verifpassword){
            return new jsonResponse(array(
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

        return new jsonResponse(array(
            'success' => true,
            'message' => 'user created !'
        ), Response::HTTP_OK);

   }
}
