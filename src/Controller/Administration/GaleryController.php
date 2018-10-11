<?php

namespace App\Controller\Administration;

use App\Entity\Galery;
use App\Entity\Image;
use App\Form\GaleryType;
use App\Form\ImageType;
use App\Manager\ImageManager;
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
    public function new(Request $request ,ImageManager $imageManager): Response
    {
        $galery = new Galery();
        $form = $this->createForm(GaleryType::class, $galery);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
            $slugger = new Slugify();
            $galery->setSlug($slugger->slugify($galery->getName()));
            dump($this->getParameter('hb.galery_image')."/".$galery->getSlug());
            $images = $form->getData()->getImages();
            foreach ($images as $key => $value) {
                dump($value);
                $image = $imageManager->createImage($value);
                $imageManager->uploadFile($value, $image->getFilename(), $this->getParameter('hb.galery_image')."/".$galery->getSlug());
                $imageManager->update($image);
                $imageManager->addImageOnGallery($galery, $image->getFilename());
                $imageManager->update($galery);
            }
            $imageManager->flush();
            $this->addFlash('success',"Galerie créée.");
            return $this->redirectToRoute('galery_index');
        }

        return $this->render('galery/new.html.twig', [
            'galery' => $galery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="galery_show", methods="GET|POST")
     */
    public function show(Galery $galery, Request $request, ImageManager $imageManager): Response
    {
        if ($request->isMethod("POST")) {
            if ($request->get('upload_submit')) {
                dump($request->get('image_file'));
                die;
            }
        }
        return $this->render(
            'galery/show.html.twig', [
                'galery' => $galery,
            ]
        );
    }

    /**
     * @Route(path="/ajout-image/{galery}", name="add_image_on_gallery")
     * @param Galery $galery
     * @param Request $request
     * @param ImageManager $imageManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addImageToGallery(Galery $galery, Request $request, ImageManager $imageManager)
    {
        if ($request->isMethod('POST')) {
            dump($request->files->all()['file_input']);
            $file = $request->files->all()['file_input'];
            $filename = $imageManager->createImage($file);
            $galery_image_count = count($galery->getImages());
            $imageManager->uploadFile($file, $filename, $this->getParameter('hb.galery_image'));
            $imageManager->addImageOnGallery($galery, $filename);
            if (count($galery->getImages()) > $galery_image_count) {
                $this->addFlash('success', "Image ajoutée à la galerie");
                return $this->redirectToRoute('galery_show', ['id' => $galery->getId()]);
            } else {
                $this->addFlash('error', "L'ajout de l'image a échoué");
                return $this->redirectToRoute('add_image_on_gallery', ['id' => $galery->getId()]);
            }
        }
        return $this->redirectToRoute('galery_show', ['id' => $galery->getId()]);
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

    /**
     * @Route(path="/delete-image/{galery}/{image}", name="delete_image_form_gallery")
     * @param Galery $galery
     * @param Image $image
     * @param ImageManager $imageManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|void
     */
    public function deleteImageFromGallery(Galery $galery, Image $image, ImageManager $imageManager)
    {
        $imageManager->validateImageAndGallery($galery, $image);
        $galery->removeImage($image);
        $imageManager->removeImageFromApp($image);
        $this->addFlash('success',"Image supprimée de la galerie !");
        return $this->redirectToRoute('galery_show', array('id' => $galery->getId()));
    }
}
