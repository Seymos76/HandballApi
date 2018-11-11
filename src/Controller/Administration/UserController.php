<?php

namespace App\Controller\Administration;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\RegisterType;
use App\Form\UserType;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Service\Mail\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods="GET")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('administration/user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     */
    public function new(Request $request, UserManager $manager, Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUsername($user->getEmail());
            $manager->update($user);
            $mailer->sendAccountActivationCode($user);
            $this->addFlash('success',"Nouvel administrateur créé ! Un e-mail lui sera envoyé afin de confirmer son accès !");
            return $this->redirectToRoute('user_index');
        }

        return $this->render('administration/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('administration/user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }

        return $this->render('administration/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route(path="/change-password", name="password_change")
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
            'administration/user/change_password.html.twig', [
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
}
