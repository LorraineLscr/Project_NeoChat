<?php

namespace App\Controller;

use App\Entity\Channel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ChannelRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(ChannelRepository $channelRepository): Response
    {   
        
        $channels = $channelRepository->findNoGeneral();
        $general = "Général";
        $generalChannel = $channelRepository->findChannelByName($general);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'channels' => $channels ?? [],
            'generalChannel' => $generalChannel
        ]);
    }


    
}
