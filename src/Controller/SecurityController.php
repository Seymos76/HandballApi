<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Manager\EntityManager;
use App\Manager\UserManager;
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
    public function register(Request $request, EntityManager $manager)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUsername($user->getEmail());
            $manager->update($user);
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
     * @Route(path="/upgrade-user/{email}/{role}", name="upgrade_user")
     * @ParamConverter("user", class="App\Entity\User")
     * @param User $user
     * @param string $role
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function upgradeUser(User $user, string $role, UserManager $manager)
    {
        $manager->upgradeUser($user->getEmail(), $role);
        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route(path="/logout", name="logout")
     */
    public function logout() {}
}
