<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('articles/homepage.html.twig');
    }
    
    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug)
    {
        $comments = [
            'Comment line 1',
            'Comment line 2',
            'Comment line 3'
        ];
        return $this->render('articles/show.html.twig', [
            'title' => ucwords(str_replace("-", " ",$slug)),
            'slug' => $slug,
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info("Article $slug being hearted");

        #TODO - actually heart/unheart the article
        return $this->json(['hearts'=> rand(5, 100)]);
    }
}
