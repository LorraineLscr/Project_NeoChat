<?php

namespace App\Controller;

use App\Repository\ChannelRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MentionsLegalesController extends AbstractController
{
    /**
     * @Route("/mentions/legales", name="app_mentions_legales")
     */
    public function index(ChannelRepository $channelRepository): Response
    {   
        $channels = $channelRepository->findNoGeneral();
        $general = "Général";
        $generalChannel = $channelRepository->findChannelByName($general);
        $user = $this->getUser();
        $mychannels = $channelRepository->findChannelByUserId($user);
        
        return $this->render('mentions_legales/index.html.twig', [
            'controller_name' => 'MentionsLegalesController',
            'channels' => $channels ?? [],
            'generalChannel' => $generalChannel,
            'mychannels' => $mychannels,
        ]);
    }
}
