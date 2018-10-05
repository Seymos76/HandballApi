<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 06/10/18
 * Time: 00:24
 */

namespace App\EventListener;

use App\Manager\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class LoginListener extends EntityManager implements EventSubscriberInterface
{
    private $flashBag;

    public function __construct(EntityManagerInterface $manager, FlashBagInterface $flashBag)
    {
        parent::__construct($manager);
        $this->flashBag = $flashBag;
    }

    public function securityLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $user->setLastConnexion(new \DateTime('now'));
        $this->update($user);
        $this->flashBag->add('success', "Bienvenue sur l'espace d'administration ". $event->getAuthenticationToken()->getUser()->getFirstname());
    }

    public static function getSubscribedEvents()
    {
        return array(
            SecurityEvents::INTERACTIVE_LOGIN => 'securityLogin'
        );
    }
}
