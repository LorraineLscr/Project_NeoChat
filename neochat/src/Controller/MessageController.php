<?php

namespace App\Controller;

use App\Entity\Message as EntityMessage;
use Symfony\Component\Mime\Message;
use App\Repository\ChannelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\debug;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\SerializerInterface as SerializerSerializerInterface;

class MessageController extends AbstractController
{

    /**
     * @Route("/message", name="message", methods={"POST", "GET"})
     */
    public function sendMessage(
        Request $request,
        ChannelRepository $channelRepository,
        SerializerSerializerInterface $serializer,
        EntityManagerInterface $em): JsonResponse
    {   
        //file_put_contents("C:/wamp64/www/ProjetNeoChat - Copie/neochat/log/info_". date('Y-m-d H:i:s') .".log", var_export($dataRecup, true));
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
        $em->flush(); // Sauvegarde du nouvel objet en DB

        $jsonMessage = $serializer->serialize($message, 'json', [
            'groups' => ['message'] // On serialize la réponse avant de la renvoyer
        ]);
        //echo "<script>console.log('{$data}' );</script>";
        return new JsonResponse( // Enfin, on retourne la réponse
            $jsonMessage,
            http_response_code(200),
            [],
            true
        );
        
    }
}
