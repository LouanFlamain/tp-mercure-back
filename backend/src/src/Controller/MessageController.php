<?php

namespace App\Controller;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Repository\MessageRepository;
use App\Repository\ChannelRepository; 
use App\Repository\UserRepository; 

class MessageController extends AbstractController
{
    #[Route('api/message', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, MessageRepository $MessageRepository, ChannelRepository $channelRepository,
    UserRepository $UserRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        $channelId = $data['channelId'] ?? null;
        $userId = $data['userId'] ?? null;
        $messageContent = $data['message']?? null;


        if(!$userId || !$channelId || !$messageContent){
            return new JsonResponse(array(
                'success' => false,
                'message' => 'not correct fields'
            ), Response::HTTP_BAD_REQUEST);
        }

        $message = new Message();
    
        // Fetch the Channel entity based on the channelId
        $channel = $channelRepository->find($channelId);

        $user = $UserRepository->find($userId);
    
        if (!$channel) {
            return new JsonResponse(['error' => 'Canal non trouvé'], 404);
        }

    
        $message->setChannel($channel); 
        $message->setUserId($user);
        $message->setText($messageContent);
    
        $entityManager->persist($message);
        $entityManager->flush();

        return $this->json([
            'message' => 'créé',
            'user'=> $user->getUsername(),
            'envoyé'=> $messageContent
        ]);
    }


    #[Route('api/messagefromchannel/{id}', methods: ['GET'])]    
    public function getMessageFromChannel
    (int $id, Request $request, MessageRepository $MessageRepository, ChannelRepository $channelRepository,
    UserRepository $UserRepository): Response
    {
            // Rechercher le canal en fonction de son ID
            $channel = $channelRepository->find($id);
        
            if (!$channel) {
                // Gérez le cas où le canal n'a pas été trouvé
                return new JsonResponse(['error' => 'Canal non trouvé'], 404);
            }
        
            // Récupérer tous les messages associés à ce canal
            $messages = $MessageRepository->findBy(['channel' => $channel]);


        
            // Créez un tableau pour stocker les données des messages
            $messageData = [];
        
            // Parcourez les messages et collectez les informations requises
            foreach ($messages as $message) {
                $user = $message->getUserId(); 
                $messageData[] = [
                    'id' => $message->getId(),
                    'message' => $message->getText(),
                    'date' => $message->getCreatedAt()->format('Y-m-d H:i:s'),
                    'user' => [
                        'id' => $user->getId(),
                        'username' => $user->getUsername(),
                    ],
                ];
            }
        
            // Retournez les messages sous forme de réponse JSON
            return $this->json(['messages' => $messageData]);

         
    }
}