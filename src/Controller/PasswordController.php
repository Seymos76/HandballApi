<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\EmailPasswordReinitialisationType;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PasswordController
 * @package App\Controller
 * @Route("/password/")
 */
class PasswordController extends AbstractController
{
    /**
     * @Route(path="change", name="password_change")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changePassword(Request $request, UserManager $manager)
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($user);
            $this->addFlash('success',"Mot de passe modifié !");
            return $this->redirectToRoute('user_index');
        }
        return $this->render(
            'password/change_password.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route(path="reinitialisation/get-your-email", name="ask_for_password_reinitialisation")
     * @param Request $request
     * @param UserManager $userManager
     * @return mixed
     */
    public function askPasswordReinitialisation(Request $request, UserManager $userManager)
    {
        $form = $this->createForm(EmailPasswordReinitialisationType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userManager->getUserByEmail($form->getData()['email']);
            $user->setToken(uniqid());
            $userManager->update($user);
            $this->addFlash('success',"Lien de réinitialisation envoyé par email");
            return $this->redirectToRoute('index');
        }
        return $this->render(
            'password/ask_password_reinitialisation.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route(path="reinitialisation/{token}", name="password_reinitialisation")
     * @param Request $request
     * @param UserManager $userManager
     * @param string $token
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function passwordReinitialisation(Request $request, UserManager $userManager, string $token)
    {
        $user = $userManager->getUserByToken($token);
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setToken(null);
            $userManager->update($user);
            $this->addFlash('success',"Mot de passe réinitialisé avec succès !");
            return $this->redirectToRoute('login');
        }
        return $this->render(
            'password/password_reinitialisation.html.twig', [
                'form' => $form->createView()
            ]
        );
    }
}
