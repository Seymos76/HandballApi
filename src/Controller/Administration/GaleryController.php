<?php

namespace App\Controller\Administration;

use App\Entity\Galery;
use App\Form\GaleryType;
use App\Repository\GaleryRepository;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/galery")
 */
class GaleryController extends AbstractController
{
    /**
     * @Route("/", name="galery_index", methods="GET")
     */
    public function index(GaleryRepository $galeryRepository): Response
    {
        return $this->render('galery/index.html.twig', ['galeries' => $galeryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="galery_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $galery = new Galery();
        $form = $this->createForm(GaleryType::class, $galery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
            $slugger = new Slugify();
            $galery->setSlug($slugger->slugify($galery->getName()));
            $em = $this->getDoctrine()->getManager();
            $em->persist($galery);
            $em->flush();
            $this->addFlash('success',"Galerie créée.");
            return $this->redirectToRoute('galery_index');
        }

        return $this->render('galery/new.html.twig', [
            'galery' => $galery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="galery_show", methods="GET")
     */
    public function show(Galery $galery): Response
    {
        return $this->render('galery/show.html.twig', ['galery' => $galery]);
    }

    /**
     * @Route("/{id}/edit", name="galery_edit", methods="GET|POST")
     */
    public function edit(Request $request, Galery $galery): Response
    {
        $form = $this->createForm(GaleryType::class, $galery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('galery_edit', ['id' => $galery->getId()]);
        }

        return $this->render('galery/edit.html.twig', [
            'galery' => $galery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="galery_delete", methods="DELETE")
     */
    public function delete(Request $request, Galery $galery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$galery->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($galery);
            $em->flush();
        }

        return $this->redirectToRoute('galery_index');
    }
}
