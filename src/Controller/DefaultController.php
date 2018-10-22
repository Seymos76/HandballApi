<?php

namespace App\Controller;


use App\Entity\Message;
use App\Form\MessageType;
use App\Manager\MessageManager;
use App\Repository\GalleryRepository;
use App\Repository\GameRepository;
use App\Repository\SlideRepository;
use App\Repository\TrainingRepository;
use App\Service\Date;
use App\Service\Mail\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route(path="/", name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SlideRepository $slideRepository, GameRepository $gameRepository, Date $date)
    {
        $slides = $slideRepository->findAll();
        $games = $gameRepository->findBy(
            array(
                'match_date' => $date->getSaturday()
            )
        );
        $results = $gameRepository->findBy(
            array(
                'match_date' => "20-10-2018"
            )
        );
        return $this->render(
            'default/index.html.twig', [
                'slides' => $slides,
                'games' => $games,
                'result' => $results
            ]
        );
    }

    /**
     * @Route(path="/entrainements", name="trainings")
     * @param TrainingRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function trainings(TrainingRepository $repository)
    {
        return $this->render(
            'default/trainings.html.twig', [
                'trainings' => $repository->findAll()
            ]
        );
    }

    /**
     * @Route(path="/matchs", name="matchs")
     * @param GameRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function matchs(GameRepository $repository)
    {
        return $this->render(
            'default/matchs.html.twig', [
                'matchs' => $repository->findAll()
            ]
        );
    }

    /**
     * @Route(path="/resultats", name="results")
     * @param GameRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function results(GameRepository $repository)
    {
        return $this->render(
            'default/results.html.twig', [
                'results' => $repository->findResults()
            ]
        );
    }

    /**
     * @Route(path="/galerie",  name="galleries")
     * @param GalleryRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function galleries(GalleryRepository $repository)
    {
        return $this->render(
            'default/galleries.html.twig', [
                'galleries' => $repository->findAll()
            ]
        );
    }

    /**
     * @Route("/galerie/{slug}", name="gallery")
     */
    public function gallery(string $slug, GalleryRepository $repository)
    {
        return $this->render(
            'default/gallery.html.twig', [
                'gallery' => $repository->findOneBy(
                    array(
                        'slug' => $slug
                    )
                )
            ]
        );
    }

    /**
     * @Route(path="/contact", name="contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request, MessageManager $messageManager, Mailer $mailer)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // save message in db
            $messageManager->update($message);
            // send email
            $mailer->sendMessage($message);
            // flash message
            $this->addFlash('success',"Message envoyé !");
            // redirection
            return $this->redirectToRoute('contact');
        }
        return $this->render(
            'default/contact.html.twig', [
                'form' => $form->createView()
            ]
        );
    }
}