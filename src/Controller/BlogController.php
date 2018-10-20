<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Manager\ArticleManager;
use App\Repository\ArticleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function article(ArticleRepository $repository, Article $article, ArticleManager $articleManager, Request $request)
    {
        $comment = new Comment();
        $comment->setArticle($article);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $articleManager->update($comment);
            $this->addFlash('success',"Commentaire ajouté !");
            return $this->redirectToRoute('article', ['slug' => $article->getSlug()]);
        }
        return $this->render(
            'blog/article.html.twig', [
                'article' => $repository->findOneBy(
                    array(
                        'slug' => $article->getSlug(),
                    )
                ),
                'form' => $form->createView()
            ]
        );
    }
}
