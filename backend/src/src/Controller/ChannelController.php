<?php

namespace App\Controller;

use App\Entity\Channel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;


class ChannelController extends AbstractController
{
    #[Route('api/channel', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        $userIds = $data['userIds']?? null;
        $name = $data['name']?? null;

        if(!$name || !$userIds){
            return new JsonResponse(array(
                'success' => false,
                'message' => 'not correct fields'
            ), Response::HTTP_BAD_REQUEST);
        }


            $channel = new Channel();
            $channel->setName($name);
            

            // Récupérez les utilisateurs à partir des identifiants
            $users = $userRepository->findBy(['id' => $userIds]);

            // Ajoutez les utilisateurs au canal
            foreach ($users as $user) {
                $channel->addUser($user);
            }

            // Enregistrez le canal en base de données
            $entityManager->persist($channel);
            $entityManager->flush();

            return $this->json([
                'channel' => "channel créé"
            ]);
    }





    #[Route('api/mychannels/{id}', methods: ['GET'])]
    public function GetMyChannels(int $id, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {

        // Récupérez l'utilisateur en fonction de l'ID
        $user = $userRepository->find($id);

        if (!$user) {
            // Gérez le cas où l'utilisateur n'a pas été trouvé
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], 404);
        }

        // Récupérez les canaux associés à l'utilisateur
        $channels = $user->getChannels();

        // Créez un tableau pour stocker les informations sur les canaux
        $channelData = [];

        // Parcourez les canaux et collectez les informations requises
        foreach ($channels as $channel) {
            $channelData[] = [
                'id' => $channel->getId(),
                'name' => $channel->getName(),
                // Ajoutez d'autres informations sur le canal si nécessaire
            ];
        }

        // Retournez les informations sur les canaux sous forme de réponse JSON
        return $this->json(['channels' => $channelData]);
    }

}