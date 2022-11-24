<?php

namespace App\Controller;

use App\Entity\Channel;
use App\Entity\User;
use App\Repository\ChannelRepository;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Discovery;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

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
    ): Response
    {
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
}

