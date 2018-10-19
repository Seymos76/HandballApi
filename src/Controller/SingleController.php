<?php

namespace App\Controller;

use App\Entity\Gallery;
use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SingleController extends AbstractController
{
    /**
     * @Route("/galerie/{slug}", name="gallery")
     */
    public function gallery(string $slug, GalleryRepository $repository)
    {
        return $this->render(
            'single/gallery.html.twig', [
                'gallery' => $repository->findOneBy(
                    array(
                        'slug' => $slug
                    )
                )
            ]
        );
    }
}
