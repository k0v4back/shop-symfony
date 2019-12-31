<?php

namespace App\Event;

use App\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisterEvent::NAME => 'userRegister'
        ];
    }

    public function userRegister(UserRegisterEvent $event)
    {
        $user = $event->getUser();
//        $this->mailer->sendEmail($event->getUser());
        $this->mailer->sendEmail('Уведомление о смене email', $user->getEmail(), 'email/registration.html.twig', [
            'token' => $user->getConfirmationToken(),
        ]);
    }

}