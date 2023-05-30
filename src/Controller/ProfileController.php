<?php

namespace App\Controller;

use App\Repository\TokenRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/docs/api', name: 'docs_api_')]
class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(TokenRepository $tokenRepository): Response
    {
        /** @var $user User */
        $user = $this->getUser();
        
       if ($user->getToken()) {
            $token = $user->getToken()->getToken();
            $date = $user->getToken()->getCreatedDate();
        }

        //Calcule le temps entre la date de création du token et maintenant
        if (isset($date) && $date instanceof \DateTime) {
            $now = new \DateTime();
            $interval = $now->diff($date);
            $years = $interval->format('%y');
            $days = $interval->format('%d');
            $hours = $interval->format('%h');
            $minutes = $interval->format('%i');
            $seconds = $interval->format('%s');
        
            $ago = 'Il y a ' . $years . ' années ' . $days . ' jours ' . $hours . ' heures ' . $minutes . ' minutes ' . $seconds . ' secondes';
        }

        //counter that updates every second

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'token' => $token ?? '',
            'date' => $ago ?? '',
        ]);
    }
}
