<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\GroupChat;
use App\Entity\User;
use DateTimeImmutable;

class GroupChatController extends AbstractController
{
    #[Route('/api/group_chat', name: 'app_group_chat')]
    public function index(): Response
    {
        return $this->render('group_chat/index.html.twig', [
            'controller_name' => 'GroupChatController',
        ]);
    }
    #[Route('/api/create_chat', 'chat.create', methods:"POST")]
    public function create_chat(EntityManagerInterface $entityManager,Request $req) : JsonResponse{
        $data = json_decode($req->getContent(), true);
        $intervenant_id = $data['intervenant'] ?? null;

        if($intervenant_id === null){
            return new JsonResponse(array(
                'success' => false,
                'code' => 400
            ), Response::HTTP_BAD_REQUEST);
        }

        $intervenant_id_json = json_encode($intervenant_id);

        $group = new GroupChat;
        $group -> setIntervenant($intervenant_id_json)
        ->setLastUpdate(new DateTimeImmutable());

        $entityManager->persist($group);
        $entityManager->flush();

        return new JsonResponse(array(
            'success' => true,
            'message' => 'group created'
        ), Response::HTTP_OK);
    }
    #[Route('/api/get_chat', 'chat.get', methods: "POST")]
    public function get_chat(Request $req, EntityManagerInterface $entityManager): JsonResponse{
        $data = json_decode($req->getContent(), true);
        $id = $data['id'] ?? null;

        if($id === null){
            return new JsonResponse(array(
                'success' => false
            ), Response::HTTP_BAD_REQUEST);
        }

        $repository = $entityManager->getRepository(GroupChat::class);
        $qb = $repository->createQueryBuilder('p');
        $qb->select('p')
        ->where('JSON_CONTAINS(p.intervenant, :intervenant) = 1')
        ->setParameter('intervenant', json_encode($id));

        $rooms = $qb->getQuery()->getResult();

        $array = [];

        foreach($rooms as $room){
            $intervenant = $room->getIntervenant();
            $id = $room->getId();
            array_push($array, [
                'intervenant' => json_decode($intervenant),
                'id' => $id
            ]);
        }

        return new JsonResponse(array(
            "data" => $array
        ), Response::HTTP_OK);
    }
}
