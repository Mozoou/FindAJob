<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Entity\BlogPost;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->UserPasswordHasherInterface = $userPasswordHasher;
    }
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setUserRandomPass'],
        ];
    }

    public function setUserRandomPass(BeforeEntityPersistedEvent $event)
    {
        $user = $event->getEntityInstance();

        if (!($user instanceof User)) {
            return;
        }
        $user->setPassword(
            $this->UserPasswordHasherInterface->hashPassword(
                    $user,
                    $this->getRandomString(),
                )
            );
        $user->setIsVerified(false);
        // TODO: SEND EMAIL WHEN USER IS CREATED FROM ADMIN WITH LINK TO CHANGE PASSWORD
    }

    // generate temporary random password
    private function getRandomString(int $n = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
      
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
      
        return $randomString;
    }
}