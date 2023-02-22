<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function show(User $user): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/profile/follows', name: 'app_profile_follows')]
    public function follows(){
        return null;
    }

    #[Route('/profile/follows2', name: 'app_profile_followers')]
    public function followers(){
        return null;
    }
}
