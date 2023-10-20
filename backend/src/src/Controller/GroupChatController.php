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
use App\Entity\Message;
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
        ->setLastUpdate(new DateTimeImmutable())
        ->setLastMessage(0);

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
            $room_id = $room->getId();

            //lastmessage et lastupdate (chat_room)

            $repository_message = $entityManager->getRepository(Message::class);
            $qb_message = $repository_message->createQueryBuilder('m');
            
            $qb_message->select('m')
                       ->where('m.chat_id = :chat_id')
                       ->setParameter('chat_id', $room_id)
                       ->orderBy('m.id', 'DESC')
                       ->setMaxResults(1);
            
            $message_data = $qb_message->getQuery()->getOneOrNullResult();
            
            // Si $message_data n'est pas null, alors vous pouvez accéder à ses propriétés
            if ($message_data) {
                $message = $message_data->getMessage();
                // Vous pouvez maintenant utiliser la variable $message pour la suite de votre logique.
            } else{
                $message = null;
            }
            


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
            array_push($array, array(
                'room_id' => $id,
                'last_message' => $message,
                'last_update' => $lastUpdate,
                'data' => $array_user,
            ));
        }

        return new JsonResponse(array(
            "data" => $array
        ), Response::HTTP_OK);
    }
}
