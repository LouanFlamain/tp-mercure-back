<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class SearchUserController extends AbstractController
{
    #[Route('/search/user', name: 'app_search_user')]
    public function index(): Response
    {
        return $this->render('search_user/index.html.twig', [
            'controller_name' => 'SearchUserController',
        ]);
    }
    #[Route('/api/search_user', 'user.search', methods: "POST")]
    public function searchUser(Request $req, EntityManagerInterface $entityManager) : JsonResponse{
        $data = json_decode($req->getContent(), true);
        $search = $data['search'] ?? null;

        if($search === null){
            return new JsonResponse(array(
                'success' => false
            ), Response::HTTP_BAD_REQUEST);
        }

        $repository = $entityManager->getRepository(User::class);
        $qb = $repository->createQueryBuilder('p');

        $offset = 0;
        $limit = 10;

        $qb = $repository->createQueryBuilder('p');
        $qb->select('p')
        ->where('p.username LIKE :username')
        ->setParameter('username', $search . '%')
        ->setFirstResult($offset) 
        ->setMaxResults($limit);  

        $users = $qb->getQuery()->getResult();

        $array = [];

        foreach($users as $user){
            $username = $user->getUsername();
            $id = $user->getId();
            $image = $user->getImage();
            array_push($array, [
                'username' => $username,
                'id' => $id,
                'image' => $image
            ]);
        }
        


        return new JsonResponse(array(
            'users' => $array
        ), Response::HTTP_OK);

    }
}
