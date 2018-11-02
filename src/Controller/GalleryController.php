<?php

namespace App\Controller;

use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GalleryController extends AbstractController
{
    /**
     * @Route(path="/galerie/{page}",  name="galleries", requirements={"page"="\d+"})
     * @param GalleryRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function galleries(GalleryRepository $repository, int $page = 1)
    {
        $perPage = 1;
        $allGalleries = $repository->findAll();
        $nbPages = ceil(count($allGalleries)/$perPage);
        $limit = ceil($page*$perPage);
        $offset = ceil($limit-$perPage);
        $galleries = $repository->findBy(
            [],
            ['id' => 'DESC'],
            $limit,
            $offset
        );
        return $this->render(
            'gallery/galleries.html.twig', [
                'galleries' => $galleries,
                'per_page' => $perPage,
                'nb_pages' => $nbPages,
                'page' => $page
            ]
        );
    }

    /**
     * @Route("/galerie/{slug}", name="gallery")
     */
    public function gallery(string $slug, GalleryRepository $repository)
    {
        return $this->render(
            'gallery/gallery.html.twig', [
                'gallery' => $repository->findOneBy(
                    array(
                        'slug' => $slug
                    )
                )
            ]
        );
    }
}
