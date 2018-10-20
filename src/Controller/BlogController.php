<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/actualites", name="blog")
     */
    public function blog(ArticleRepository $repository)
    {
        return $this->render('blog/blog.html.twig', [
            'articles' => $repository->findAll(),
        ]);
    }

    /**
     * @Route(path="/actualites/{slug}", name="article")
     * @ParamConverter("article", class="App\Entity\Article")
     * @param ArticleRepository $repository
     * @return Response
     */
    public function article(ArticleRepository $repository, Article $article)
    {
        return $this->render(
            'blog/article.html.twig', [
                'article' => $repository->findOneBy(array('slug' => $article->getSlug()))
                ]
            );
    }
}
