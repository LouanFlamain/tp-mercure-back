<?php

namespace App\Controller;

use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;
use App\Entity\User;
use App\Entity\GroupChat;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
    #[Route('/api/create_message', 'message.create', methods: "POST")]
    public function createMessage(Request $req, EntityManagerInterface $entityManager):JsonResponse{
        $data = json_decode($req->getContent(), true);
        $messageText = $data['message'] ?? null;
        $user_id = $data['user_id'] ?? null;
        $chat_id = $data['chat_id'] ?? null;
        $createdAt = new DateTimeImmutable();

        if($data === null){
            return new JsonResponse(array(
                'success' => false
            ), Response::HTTP_BAD_REQUEST);
        }

        $message = new Message;

        $message
        ->setChatId($chat_id)
        ->setUserId($user_id)
        ->setMessage($messageText)
        ->setCreatedAt($createdAt);
        
        $entityManager->persist($message);
        $entityManager->flush();

        $message_id = $message->getId();

        $repository = $entityManager->getRepository(GroupChat::class);
        $qb = $repository->find($chat_id);

        if($qb){
            $qb->setLastMessage($message_id)
            ->setLastUpdate($createdAt);
            $entityManager->flush();
        }


        return new JsonResponse(array(
            'success' => true,
            "message" => 'message created',
        ), Response::HTTP_OK);
    }   
    #[Route('/api/get_message', 'message.get', methods: "POST")]
    public function getMessage(Request $req, EntityManagerInterface $entityManager):JsonResponse{
        $data = json_decode($req->getContent(), true);
        $chat_id = $data['chat_id'] ?? null;
        $offset = $data['offset'] ?? null;

        if($chat_id === null || $offset === null){
            return new JsonResponse(array(
                'success' => false
            ), Response::HTTP_BAD_REQUEST);
        }

        $limit = 30;
        
        $repository = $entityManager->getRepository(Message::class);
        $qb = $repository->createQueryBuilder('p');
        $qb->select('p')
        ->where('p.chat_id = :chat_id')
        ->orderBy('p.id', 'DESC') 
        ->setParameter('chat_id', $chat_id)
        ->setFirstResult($offset) 
        ->setMaxResults($limit);  

        $messages = $qb->getQuery()->getResult();

        $repository_user = $entityManager->getRepository(User::class);

        $array = [];

        foreach($messages as $message){
            $user_id = $message->getUserId();
            $messageText = $message->getMessage();
            $createdAt = $message->getCreatedAt();

            $qb_user = $repository_user->createQueryBuilder('u');
            $qb_user->select('u')
            ->where('u.id = :id')
            ->setParameter('id', $user_id);
            $users = $qb_user->getQuery()->getResult();;
            $username = $users[0]->getUsername();

            array_push($array, array(
                'username' => $username,
                'message' => $messageText,
                'created_at' => $createdAt
            ));
        }

        return new JsonResponse(array(
            'data' => $array
        ), Response::HTTP_OK);
    }
}
