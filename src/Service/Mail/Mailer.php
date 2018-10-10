<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 10/10/18
 * Time: 16:27
 */

namespace App\Service\Mail;


use App\Entity\User;
use Psr\Container\ContainerInterface;

class Mailer
{
    private $mailer;
    private $container;

    public function __construct(\Swift_Mailer $mailer, ContainerInterface $container)
    {
        $this->mailer = $mailer;
        $this->container = $container;
    }

    public function sendAccountActivationCode(User $user)
    {
        $message = (new \Swift_Message("Activation de votre compte utilisateur"))
            ->setTo($user->getEmail())
            ->setFrom('no-reply@forgesleseauxhandball.fr')
            ->setCharset("UTF-8")
            ->setBody(
                $this->container->get('twig')->render(
                    'email/account_activation.html.twig',
                    array('user' => $user)
                ),
                'text/html'
            );
        $this->mailer->send($message);
        return true;
    }
}