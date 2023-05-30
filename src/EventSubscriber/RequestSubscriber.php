<?php

namespace App\EventSubscriber;

use App\Repository\TokenBlackListRepository;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Symfony\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RequestSubscriber implements EventSubscriberInterface
{

    private $tokenBlackListRepository;

    public function __construct(TokenBlackListRepository $tokenBlackListRepository)
    {
        $this->tokenBlackListRepository = $tokenBlackListRepository;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events when get called
        return [
            KernelEvents::REQUEST => [
                ['onPreRead', EventPriorities::PRE_READ],
            ]
        ];
    }

    public function onPreRead($event)
    {
        // get the bearer token from the request header and check if it is blacklisted or not
        // if it is blacklisted then throw an exception
        $token = $event->getRequest()->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $token);
        $tokenBlackList = $this->tokenBlackListRepository->findOneBy(['token' => $token]);
        // if token is blacklisted then throw an exception and return a 401 response code to the client
        if ($tokenBlackList) { 
            $event->setResponse(new JsonResponse([
                'error' => 'Unauthorized',
                'message' => 'Token is blacklisted. Please generate new token.'
            ], 401));
        }
    }
}