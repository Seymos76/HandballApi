<?php

namespace App\Controller;


use App\Entity\Message;
use App\Form\MessageType;
use App\Manager\MessageManager;
use App\Repository\GalleryRepository;
use App\Repository\GameRepository;
use App\Repository\MeetingRepository;
use App\Repository\SlideRepository;
use App\Repository\TeamRepository;
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
    public function index(SlideRepository $slideRepository, MeetingRepository $meetingRepository, Date $date)
    {
        $saturday = $date->getNextSaturday();
        $prev_saturday = $date->getPreviousSaturday();
        dump($prev_saturday);
        dump($saturday);
        $slides = $slideRepository->findAll();
        $next_meeting = $meetingRepository->findNextMeeting($saturday);
        $last_meeting = $meetingRepository->findLastMeeting($prev_saturday);
        dump($next_meeting);
        dump($last_meeting);
        return $this->render(
            'default/index.html.twig', [
                'slides' => $slides,
                'next_meeting' => $next_meeting,
                'last_meeting' => $last_meeting
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
    public function games(GameRepository $repository)
    {
        return $this->render(
            'default/matchs.html.twig', [
                'matchs' => $repository->findAll()
            ]
        );
    }

    /**
     * @Route(path="/les-equipes", name="teams")
     * @param TeamRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function teams(TeamRepository $repository)
    {
        return $this->render(
            'default/teams.html.twig', [
                'teams' => $repository->findAll()
            ]
        );
    }

    /**
     * @Route(path="/equipe/{slug}", name="team")
     * @param TeamRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function team(TeamRepository $repository, string $slug)
    {
        return $this->render(
            'default/team.html.twig', [
                'team' => $repository->findOneBy(
                    array(
                        'slug' => $slug
                    )
                )
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