<?php

namespace App\Controller;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\GroupChat;
use App\Entity\User;
use DateTimeImmutable;

use function PHPSTORM_META\type;

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
            $lastUpdate = $room->getLastUpdate();

            $array_user = [];

            $intervenant = json_decode($intervenant);
            $repository_user = $entityManager->getRepository(User::class);
            foreach($intervenant as $user_id){
                $qb_user = $repository_user->createQueryBuilder('u');
                $qb_user->select('u')
                ->where('u.id = :id')
                ->setParameter('id', $user_id);
                $users = $qb_user->getQuery()->getResult();;
                $username = $users[0]->getUsername();
                array_push($array_user, array(
                    'username' => $username,
                    'user_id' => $user_id
                ));
            }

            $repository = $entityManager->getRepository(Message::class);
            $qb_message = $repository->createQueryBuilder('p');
            $qb_message->select('p')
                ->where('p.chat_id = :chat_id')
                ->orderBy('p.createdAt', 'DESC') 
                ->setParameter('chat_id', $id)
                ->setMaxResults(1);
            
            $results = $qb_message->getQuery()->getResult();
            
            if (!empty($results)) {
                $message = $results[0]->getMessage();
            } else {
                $message = 'Add a new message';
            }
            
            array_push($array, array(
                'room_id' => $id,
                'last_update' => $lastUpdate,
                'data' => $array_user,
                'last_message' => $message
            ));
        }

        return new JsonResponse(array(
            "data" => $array
        ), Response::HTTP_OK);
    }

    #[Route('/api/update_chat', 'chat.update', methods:"PUT")]
    public function chat_update(EntityManagerInterface $entityManager,Request $req) : JsonResponse{
        $data = json_decode($req->getContent(), true);
        $newUserId = $data['newUser'] ?? null;
        $idChannel = $data['idChannel'] ?? null;
        $participant = $data['participant'] ?? null;

        if($newUserId === null || $idChannel === null || $participant === null){
            return new JsonResponse(array(
                'success' => false,
                'code' => 400
            ), Response::HTTP_BAD_REQUEST);
        }

        $newUser = $entityManager->getRepository(User::class)->find($newUserId);

        $group = $entityManager->getRepository(GroupChat::class)->find($idChannel);

        if ($newUser && $group) {

            $id = $newUser -> getId();
            $initialParticipant = $group -> getIntervenant();
            $array = json_decode($initialParticipant, true);

            if (!in_array($participant, $array)) {
                return new JsonResponse(array(
                    'success' => false,
                    'message' => 'The user who add new user is not in the channel'
                ), Response::HTTP_NOT_FOUND);
            }
            $array[] = $id;
            $array_json = json_encode($array);

            $group-> setIntervenant($array_json);


            $entityManager->persist($group);
            $entityManager->flush();
    
            return new JsonResponse(array(
                'success' => true,
                'message' => "Group updated"
            ), Response::HTTP_OK);
        } else {
            return new JsonResponse(array(
                'success' => false,
                'message' => 'User or group not found'
            ), Response::HTTP_NOT_FOUND);
        }

    }
}