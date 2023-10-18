<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class CheckUserValidController extends AbstractController
{
    #[Route('/check/user/valid', name: 'app_check_user_valid')]
    public function index(): Response
    {
        return $this->render('check_user_valid/index.html.twig', [
            'controller_name' => 'CheckUserValidController',
        ]);
    }
    #[Route('/api/check_valid', 'user.check_valid', methods: "GET")]
    public function checkValid(): JsonResponse{

        return new JsonResponse(array(
            'code' => 200,
            'message' => 'utilisateur valide'
        ), Response::HTTP_OK);
    }
    #[Route('/api/get_informations', 'user.getInformations', methods: "POST")]
    public function getUserInformations(EntityManagerInterface $entityManager, Request $req) : JsonResponse{

        $data = json_decode($req->getContent(), true);

        $email = $data['email'] ?? null;

        if($email !== null){
            $repository = $entityManager->getRepository(User::class);
            $qb = $repository->createQueryBuilder('p');
            $qb->select('p')
            ->where('p.email = :email')
            ->setParameter('email', $email);
    
            $user = $qb->getQuery()->getOneOrNullResult();
    
            $username = $user->getUsername();
            $id = $user->getId();
            $role = $user->getRoles();
            $createdAt = $user->getCreatedAt();
            $image = $user->getImage();
    
            return new JsonResponse(array(
                'code' => 200,
                'username' => $username,
                'id' => $id,
                'createdAt' => $createdAt,
                'role' => $role,
                'email' => $email,
                'image' => $image
            ));
        }
        return new JsonResponse((array(
            'code' => 403,
            'message' => 'access forbidden'
        )));
    }
}
