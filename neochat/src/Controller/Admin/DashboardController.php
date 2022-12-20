<?php

namespace App\Controller\Admin;

use App\Entity\Channel;
use App\Entity\Message;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Neochat');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Les utilisateurs', 'fa fa-user', User::class); 
        yield MenuItem::linkToCrud('Les channels', 'fa fa-hashtag', Channel::class);
        yield MenuItem::linkToCrud('Les messages', 'fas fa-comments', Message::class);  
        yield MenuItem::linkToRoute('Retour à l\'accueil', 'fa fa-door-open', ('app_home')); 
    }
}
