<?php

namespace App\Controller\Administration;

use App\Entity\Meeting;
use App\Form\MeetingType;
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
        $meeting->setMeetingDate($date->getLastSaturday());
        dump($meeting);
        die;
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
        ]);
    }

    /**
     * @Route("/{id}", name="meeting_show", methods="GET")
     */
    public function show(Meeting $meeting): Response
    {
        return $this->render('administration/meeting/show.html.twig', ['meeting' => $meeting]);
    }

    /**
     * @Route("/{id}/edit", name="meeting_edit", methods="GET|POST")
     */
    public function edit(Request $request, Meeting $meeting): Response
    {
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('meeting_edit', ['id' => $meeting->getId()]);
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
