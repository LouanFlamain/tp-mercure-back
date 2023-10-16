<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

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
    #[Route('/api/get_informations', 'user.getInformations', methods: "GET")]
    public function getUserInformations(EntityManagerInterface $entityManager) : JsonResponse{

        $email = 'admin@admin.fr';

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

        return new JsonResponse(array(
            'code' => 200,
            'username' => $username,
            'id' => $id,
            'createdAt' => $createdAt,
            'role' => $role
        ));
    }
}
