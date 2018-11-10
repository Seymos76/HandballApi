<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Manager\EntityManager;
use App\Manager\UserManager;
use App\Service\Mail\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        $lastUsername = $utils->getLastUsername();
        $error = $utils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route(path="/inscription", name="register")
     * @param Request $request
     * @param EntityManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, EntityManager $manager, Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUsername($user->getEmail());
            $manager->update($user);
            $mailer->sendAccountActivationCode($user);
            $this->addFlash('success',"Inscription réussie !");
            return $this->redirectToRoute('login');
        }
        return $this->render(
            'security/register.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route(path="/activation-compte/{code}", name="account_activation")
     * @param string $code
     * @param UserManager $userManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activateAccount(string $code, UserManager $userManager)
    {
        if (!is_string($code)) {
            return $this->redirectToRoute('register');
        }
        $user = $userManager->getUserByActivationCode($code);
        $activated = $userManager->activateUser($user);
        if ($activated === true) {
            $this->addFlash('success',"Votre compte a été activé, vous pouvez désormais vous connecter !");
            return $this->redirectToRoute('login');
        } else {
            $this->addFlash('error',"Erreur lors de l'activation de votre compte");
            return $this->redirectToRoute('index');
        }
    }

    /**
     * @Route(path="/logout", name="logout")
     */
    public function logout() {}
}
