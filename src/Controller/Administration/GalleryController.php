<?php

namespace App\Controller\Administration;

use App\Entity\Gallery;
use App\Entity\Image;
use App\Form\GalleryType;
use App\Manager\GalleryManager;
use App\Manager\ImageManager;
use App\Repository\GalleryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gallery")
 */
class GalleryController extends AbstractController
{
    /**
     * @Route("/", name="gallery_index", methods="GET")
     */
    public function index(GalleryRepository $galleryRepository): Response
    {
        return $this->render('gallery/index.html.twig', ['galleries' => $galleryRepository->findAll()]);
    }

    /**
     * @Route("/new", name="gallery_new", methods="GET|POST")
     */
    public function new(Request $request, GalleryManager $galleryManager): Response
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $galleryManager->createGallery($gallery);
            $this->addFlash('success',"Galerie ajoutée !");
            return $this->redirectToRoute('gallery_index');
        }

        return $this->render('gallery/new.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gallery_show", methods="GET")
     */
    public function show(Gallery $gallery): Response
    {
        return $this->render('gallery/show.html.twig', ['gallery' => $gallery]);
    }

    /**
     * @Route("/{id}/edit", name="gallery_edit", methods="GET|POST")
     */
    public function edit(Request $request, Gallery $gallery): Response
    {
        $form = $this->createForm(GalleryType::class, $gallery);
        $gallery_images_count = count($gallery->getImages());
        dump($gallery_images_count);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new_count = $gallery->getImages();
            dump($new_count);
            die;
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gallery_edit', ['id' => $gallery->getId()]);
        }

        return $this->render('gallery/edit.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove-image-from-gallery/{gallery}/{image}", name="image_gallery_delete")
     * @ParamConverter("gallery", class="App\Entity\Gallery")
     * @ParamConverter("image", class="App\Entity\Image")
     * @param Request $request
     * @param Gallery $gallery
     * @param Image $image
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteImageFromGallery(Request $request, Gallery $gallery, Image $image, GalleryManager $galleryManager)
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $gallery->removeImage($image);
            $galleryManager->removeImageFromApp($image, $this->getParameter('hb.gallery_image')."/".$gallery->getDateCreation()->format('Y'));
            $galleryManager->update($gallery);
            $this->addFlash('success',"Image supprimée de la galerie !");
        }

        return $this->redirectToRoute('gallery_edit', array('id' => $gallery->getId()));
    }

    /**
     * @Route("/{id}", name="gallery_delete", methods="DELETE")
     */
    public function delete(Request $request, Gallery $gallery, GalleryManager $galleryManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gallery->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $images = $gallery->getImages();
            foreach ($images as $image) {
                $galleryManager->removeImageFromApp($image, $this->getParameter('hb.gallery_image')."/".$gallery->getDateCreation()->format('Y'));
                $gallery->removeImage($image);
            }
            $em->remove($gallery);
            $em->flush();
            $this->addFlash('success',"Galerie supprimée !");
        }

        return $this->redirectToRoute('gallery_index');
    }
}
