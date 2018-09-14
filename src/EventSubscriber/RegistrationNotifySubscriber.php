<?php
namespace App\EventSubscriber;
 
use App\Entity\User;
use App\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
 
/**
 * Envoi un mail de bienvenue à chaque creation d'un utilisateur
 *
 */
class RegistrationNotifySubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $sender;
 
    public function __construct(\Swift_Mailer $mailer, $sender)
    {
        // On injecte notre expediteur et la classe pour envoyer des mails
        $this->mailer = $mailer;
        $this->sender = $sender;
    }
 
    public static function getSubscribedEvents(): array
    {
        return [
            // le nom de l'event et le nom de la fonction qui sera déclenché
            Events::USER_REGISTERED => 'onUserRegistrated',
            Events::DONATION_DONE => 'donationDone'
        ];
    }
 
    public function onUserRegistrated(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();
 
        $subject = "Welcome to GreenLiten !";
        $body = "Dear ".$user->getFullName().",<br>
        Welcome to our web site! We are very happy to have you with us and knowing that more and more people are supporting the red panda’s cause really matter to our association, Green Liten. 
        We hope that you will learn more about the red panda and about the operations that we project to carry out.<br>
        Yours sincerely,<br> 
        The Green Liten association.
        ";
 
        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setTo($user->getEmail())
            ->setFrom($this->sender)
            ->setBody($body, 'text/html')
        ;
 
        $this->mailer->send($message);
    }

    public function donationDone(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();
 
        $subject = "Thanks for your donation.";
        $body = "Dear ".$user->getFullName().",<br><br>
        We are sending you this little message to tell you how thankful we are for your donation.           Financing this operation means a lot to us, and you don’t even know how pleased we are because of what you did. 
        You showed how much red pandas are important to you, and you did something that may help us to fight against the lesser panda’s endangered status. 
        <br>
        Thank you again.<br><br>
        Yours sincerely, 
        The Green Liten association.
        ";
 
        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setTo($user->getEmail())
            ->setFrom($this->sender)
            ->setBody($body, 'text/html')
        ;
 
        $this->mailer->send($message);
    }
}
?>