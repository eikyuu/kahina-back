<?php

namespace App\Components;

use App\Entity\Token;
use App\Repository\TokenBlackListRepository;
use App\Repository\TokenRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


#[AsLiveComponent('generate_token')]
class GenerateTokenComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $token = '';
    #[LiveProp(writable: true)]
    public string $date = '';

    public function __construct(private JWTTokenManagerInterface $JWTManager, private TokenRepository $tokenRepository,private TokenBlackListRepository $tokenBlackListRepository, private EntityManagerInterface $entityManager, private TokenStorageInterface $tokenStorageInterface)
    {}

    #[LiveAction]
    public function generateToken()
    {
        $user = $this->getUser();
        $this->token = $this->JWTManager->create($user);

        //Vérifie si le token existe déjà
        $token = $this->tokenRepository->findOneBy(['user' => $user]) ?? new Token();

        //Si le token n'existe pas, on le crée et on l'associe à l'utilisateur connecté et on enregistre la date de création du token dans la base de données
        if (is_null($token->getToken())) {
            $token->setToken($this->token);
            $token->setUser($user);
            $token->setCreatedDate(new DateTime());
        } else {
            //Sinon on met à jour le token et la date de création du token dans la base de données et on enregistre le nouveau token dans la variable $token de la classe
            $token = $this->tokenRepository->findOneBy(['user' => $user]);

            $this->tokenBlackListRepository->addTokenToBlackList($token->getToken());
            $token->setToken($this->token);
            $token->setCreatedDate(new DateTime());
        }

        //Calcule le temps entre la date de création du token et maintenant
        $now = new DateTime();
        $interval = $now->diff($token->getCreatedDate());
        $years = $interval->format('%y');
        $days = $interval->format('%d');
        $hours = $interval->format('%h');
        $minutes = $interval->format('%i');
        $seconds = $interval->format('%s');
    
        $this->date = 'Il y a ' . $years . ' années ' . $days . ' jours ' . $hours . ' heures ' . $minutes . ' minutes ' . $seconds . ' secondes';

        $this->entityManager->persist($token);
        $this->entityManager->flush();
    }

}