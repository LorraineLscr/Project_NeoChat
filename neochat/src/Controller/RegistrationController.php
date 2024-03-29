<?php

namespace App\Controller;

use App\Entity\User;
use Gumlet\ImageResize;
use App\Form\RegistrationFormType;
use App\Repository\ChannelRepository;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @Route("/editUser/{id}", name="editUser")
     */
    public function register(
        ChannelRepository $channelRepository,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        LoginFormAuthenticator $authenticator,
        EntityManagerInterface $entityManager,
        User $user = null
    ): Response {
        if(!$user){
            $user = new User();
        }

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()) {
                // comment obtenir l'url du dossier public ?
                $dirUpload = str_replace("\\", "/", $this->getParameter('upload_directory')) . "/";
                // utiliser la fonction moveUploadFile de php
                move_uploaded_file(
                    $_FILES['registration_form']['tmp_name']['avatar'],
                    $dirUpload . $_FILES['registration_form']['name']['avatar']
                );
                $user->setRoles(
                    ['ROLE_USER']
                );
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();

                // redimensionner mon image + changer son expression + save in avatar
                $dirAvatar = str_replace("\\", "/", $this->getParameter('avatar_directory')) . "/";
                $image = new ImageResize($dirUpload . $_FILES['registration_form']['name']['avatar']);
                $image->resizeToWidth(100);
                $image->save($dirAvatar . $user->getId() . '.png', IMAGETYPE_PNG);

                // après mes opérations je supprime l'image d'origine
                unlink($dirUpload . $_FILES['registration_form']['name']['avatar']);

                // do anything else you need here, like send an email
                return $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                );
            }
        }
        $mode = false;
        if ($user->getId() !== null) {
            $mode = true;
        }

        $general = "Général";
        $generalChannel = $channelRepository->findChannelByName($general);
        $channels = $channelRepository->findNoGeneral();
        if($mode === true){
            $mychannels = $channelRepository->findChannelByUserId($user);
            return $this->render('registration/register.html.twig', [
                'generalChannel' => $generalChannel,
                'channels' => $channels,
                'mychannels' => $mychannels,
                'registrationForm' => $form->createView(),
                'mode' => $mode
            ]);
        } else {
            return $this->render('registration/register.html.twig', [
                'generalChannel' => $generalChannel,
                'channels' => $channels,
                'mychannels' => '',
                'registrationForm' => $form->createView(),
                'mode' => $mode
            ]);
        }
        

        
    }
}
