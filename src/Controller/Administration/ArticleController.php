<?php

namespace App\Controller\Administration;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Manager\ArticleManager;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods="GET")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('administration/article/index.html.twig', ['articles' => $articleRepository->findAll()]);
    }

    /**
     * @Route("/new", name="article_new", methods="GET|POST")
     */
    public function new(Request $request, ArticleManager $articleManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $articleManager->createArticle($article);
            $this->addFlash('success',"Articlé créé !");
            return $this->redirectToRoute('article_index');
        }

        return $this->render('administration/article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods="GET")
     */
    public function show(Article $article): Response
    {
        return $this->render('administration/article/show.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods="GET|POST")
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_edit', ['id' => $article->getId()]);
        }

        return $this->render('administration/article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods="DELETE")
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
