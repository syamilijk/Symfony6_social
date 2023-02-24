<?php

namespace App\Controller;

use App\Entity\UserProfile;
use App\Form\UserProfileType;
use App\Form\ProfileImageType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SettingsProfileController extends AbstractController
{
    #[Route('/settings/profile', name: 'app_settings_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profile(
        Request $request,
        UserRepository $users
    ): Response
    {
        $user = $this->getUser();
        $userProfile = $user->getUserProfile() ?? new UserProfile();

        $form = $this->createForm(
            UserProfileType::class, $userProfile
        );
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $userprofile = $form->getData();

            $user->setUserProfile($userProfile);
            $users->save($user, true);
            $this->addFlash(
               'success',
               'Your user profile settings were saved!'
            );
            return $this->redirectToRoute('app_settings_profile');
        }

        return $this->render(
            'settings_profile/profile.html.twig', 
            [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/settings/profile-image', name: 'app_settings_profile_image')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profileImage() : Response {
        $form = $this->createForm(ProfileImageType::class);
        return $this->render(
            'settings_profile/profile_image.html.twig', 
            [
                'form' => $form->createView(),
            ]
        );
    }
}
