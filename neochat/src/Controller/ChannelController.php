<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Channel;
use App\Form\ChannelUserType;
use App\Repository\UserRepository;
use App\Repository\ChannelRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mercure\Discovery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\Security\Core\User\UserInterface;

class ChannelController extends AbstractController
{
    /**
     * @Route("/channel", name="app_channel")
     */
    public function index(): Response
    {
        return $this->render('channel/index.html.twig', [
            'controller_name' => 'ChannelController',
        ]);
    }

    /**
     * @Route("/", name="channel")
     */
    public function getChannels(ChannelRepository $channelRepository): Response
    {
        $channels = $channelRepository->findAll();

        return $this->render('base.html.twig', [
            'channels' => $channels ?? []
        ]);
    }


    /**
     * @Route("/chat/{id}", name="chat")
     */
    public function chat(
        ChannelRepository $channelRepository,
        Channel $channel,
        MessageRepository $messageRepository,
        Discovery $discovery,
        HttpFoundationRequest $request
    ): Response {
        $channels = $channelRepository->findAll();
        $messages = $messageRepository->findBy([
            'channel' => $channel
        ], ['date' => 'ASC']);

        $discovery->addLink($request);

        return $this->render('channel/chat.html.twig', [
            'channels' => $channels,
            'channel' => $channel,
            'messages' => $messages
        ]);
    }

    /**
     * @Route("/createChannel", name="createChannel")
     */
    public function createChannel(
        Request $request,
        ManagerRegistry $doctrine,
        ChannelRepository $channelRepository,
        UserInterface $user
    ){
        $channel = new Channel();
        $form = $this->createForm(ChannelUserType::class, $channel);
        $form->handleRequest($request);

        $channels = $channelRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $channel->setUser($user);
            $om  = $doctrine->getManager();
            $om->persist($channel);
            $om->flush();
            return $this->redirectToRoute('app_home');
        };

        return $this->render('channel/createChannel.html.twig', [
            'channels' => $channels,
            'createChannelForm' => $form->createView(),
        ]);
    }
}
