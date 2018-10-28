<?php

namespace App\Controller\Administration;

use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Form\MeetingValidatorType;
use App\Form\ResultType;
use App\Manager\MeetingManager;
use App\Repository\MeetingRepository;
use App\Service\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/meeting")
 */
class MeetingController extends AbstractController
{
    /**
     * @Route("/", name="meeting_index", methods="GET")
     */
    public function index(MeetingRepository $meetingRepository): Response
    {
        return $this->render('administration/meeting/index.html.twig', ['meetings' => $meetingRepository->findAll()]);
    }

    /**
     * @Route("/new", name="meeting_new", methods="GET|POST")
     */
    public function new(Request $request, Date $date, MeetingManager $meetingManager): Response
    {
        $meeting = new Meeting();
        $saturday = $date->getNextSaturday();
        $meeting->setMeetingDate($saturday);
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meetingManager->saveMeetingGames($meeting);
            $em = $this->getDoctrine()->getManager();
            $em->persist($meeting);
            $em->flush();

            return $this->redirectToRoute('meeting_index');
        }

        return $this->render('administration/meeting/new.html.twig', [
            'meeting' => $meeting,
            'form' => $form->createView(),
            'saturday' => $saturday
        ]);
    }

    /**
     * @Route("/{id}", name="meeting_show", methods="GET|POST")
     */
    public function show(Meeting $meeting, Request $request): Response
    {
        $games = $meeting->getGames();
        $formValidator = $this->createForm(MeetingValidatorType::class, $meeting);
        $array_forms = array();
        foreach ($games as $game) {
            $form = $this->createForm(ResultType::class, $game);
            array_push($array_forms, $form->createView());
        }
        return $this->render('administration/meeting/show.html.twig',
            ['meeting' => $meeting, 'forms' => $array_forms, 'form' => $formValidator->createView()]
        );
    }

    /**
     * @Route("/{id}/edit", name="meeting_edit", methods="GET|POST")
     */
    public function edit(Request $request, Meeting $meeting, MeetingManager $meetingManager): Response
    {
        $form = $this->createForm(MeetingType::class, $meeting);
        $nb_matchs = $meeting->getGames()->count();
        dump((int)$nb_matchs);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($meeting->getGames()->count());
            $new_count = $meeting->getGames()->count();
            $new_count = (int)$new_count;
            dump($new_count);
            if ($new_count > $nb_matchs) {
                foreach ($meeting->getGames() as $game) {
                    if ($game->getId() === null) {
                        $game->setMeeting($meeting);
                        $meetingManager->update($game);
                    }
                }
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('meeting_show', ['id' => $meeting->getId()]);
        }

        return $this->render('administration/meeting/edit.html.twig', [
            'meeting' => $meeting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="meeting_delete", methods="DELETE")
     */
    public function delete(Request $request, Meeting $meeting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meeting->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($meeting);
            $em->flush();
        }

        return $this->redirectToRoute('meeting_index');
    }
}
