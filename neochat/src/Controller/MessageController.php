<?php

namespace App\Controller;

use App\Repository\ChannelRepository;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\PublisherInterface;
use App\Entity\Message as EntityMessage;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MessageController extends AbstractController
{

    /**
     * @Route("/message", name="message", methods={"POST", "GET"})
     */
   
    public function sendMessage(
        Request $request,
        ChannelRepository $channelRepository,
        EntityManagerInterface $em,
        PublisherInterface $publisher): JsonResponse{

        $data = json_decode($request->getContent()); // On récupère les data postées et on les déserialize
        
        if (empty($data->content)) {
            throw new AccessDeniedHttpException('No data sent');
        }
        $channel = $channelRepository->findOneBy([
            'id' => $data->channel // On cherche à savoir de quel channel provient le message
        ]);
        if (!$channel) {
            throw new AccessDeniedHttpException('Message have to be sent on a specific channel');
        }

        $message = new EntityMessage; // Après validation, on crée le nouveau message
        $message->setContent($data->content);
        $message->setChannel($channel);
        $message->setUser($this->getUser()); // On lui attribue comme auteur l'utilisateur courant

        $em->persist($message);
        $em->flush(); // Sauvegarde sur la DB

        $serializer = SerializerBuilder::create()->build();
        $jsonMessage = $serializer->serialize($message, 'json', SerializationContext::create()->setGroups(['Default', 'message']));

        $update = new Update( // Création d'une nouvelle update
            sprintf('/chat/%s', // On précise le topic, avec pour Id l'identifiant de notre Channel
                $channel->getId()),
            $jsonMessage // On y passe le message serializer en content value
        );

        $publisher($update); // On le publie sur le hub

        return new JsonResponse( // Enfin, on retourne la réponse
            $jsonMessage,
            http_response_code(200),
            [],
            true
        );
        
    }
}
