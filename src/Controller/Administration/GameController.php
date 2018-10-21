<?php

namespace App\Controller\Administration;

use App\Entity\Game;
use App\Form\GameType;
use App\Form\ResultType;
use App\Manager\GameManager;
use App\Repository\GameRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/", name="game_index", methods="GET")
     */
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('administration/game/index.html.twig', ['games' => $gameRepository->findAll()]);
    }

    /**
     * @Route("/new", name="game_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('game_index');
        }

        return $this->render('administration/game/new.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_show", methods="GET")
     */
    public function show(Game $game): Response
    {
        return $this->render('administration/game/show.html.twig', ['game' => $game]);
    }

    /**
     * @Route("/{id}/edit", name="game_edit", methods="GET|POST")
     */
    public function edit(Request $request, Game $game, GameManager $manager): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($game);
            $this->addFlash('success',"Match mis à jour !");
            return $this->redirectToRoute('game_show', ['id' => $game->getId()]);
        }

        return $this->render('administration/game/edit.html.twig', [
            'game' => $game,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/{id}/validate-match", name="game_validate", methods="GET|POST")
     * @ParamConverter("game", class="App\Entity\Game")
     * @param Request $request
     * @param Game $game
     * @param GameManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function validateGame(Request $request, Game $game, GameManager $manager)
    {
        $form = $this->createForm(ResultType::class, $game);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->update($game);
            $this->addFlash('success',"Match mis à jour avec les résultats !");
            return $this->redirectToRoute('game_show', ['id' => $game->getId()]);
        }
        return $this->render('administration/game/validate.html.twig', [
            'game' => $game,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="game_delete", methods="DELETE")
     */
    public function delete(Request $request, Game $game): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush();
        }

        return $this->redirectToRoute('game_index');
    }
}
