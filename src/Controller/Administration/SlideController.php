<?php

namespace App\Controller\Administration;

use App\Entity\Slide;
use App\Form\SlideType;
use App\Manager\SlideManager;
use App\Repository\SlideRepository;
use App\Service\Image\Uploader;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/slide")
 */
class SlideController extends AbstractController
{
    /**
     * @Route("/", name="slide_index", methods="GET")
     */
    public function index(SlideRepository $slideRepository): Response
    {
        return $this->render('administration/slide/index.html.twig', ['slides' => $slideRepository->findAll()]);
    }

    /**
     * @Route("/new", name="slide_new", methods="GET|POST")
     */
    public function new(Request $request, SlideManager $slideManager): Response
    {
        $form = $this->createForm(SlideType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slideManager->createSlide($form->getData());
            $this->addFlash('success',"Slide créé !");
            return $this->redirectToRoute('slide_index');
        }

        return $this->render('administration/slide/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slide_show", methods="GET")
     */
    public function show(Slide $slide): Response
    {
        return $this->render('administration/slide/show.html.twig', ['slide' => $slide]);
    }

    /**
     * @Route("/{id}/edit", name="slide_edit", methods="GET|POST")
     */
    public function edit(Request $request, Slide $slide, SlideManager $slideManager): Response
    {
        $form = $this->createForm(SlideType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slide = $slideManager->updateSlide($form->getData(), $slide);
            $this->addFlash('success',"Slide mis à jour !");
            return $this->redirectToRoute('slide_edit', ['id' => $slide->getId()]);
        }

        return $this->render('administration/slide/edit.html.twig', [
            'slide' => $slide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="slide_delete", methods="DELETE")
     */
    public function delete(Request $request, Slide $slide): Response
    {
        if ($this->isCsrfTokenValid('delete'.$slide->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($slide);
            $em->flush();
        }

        return $this->redirectToRoute('slide_index');
    }
}
