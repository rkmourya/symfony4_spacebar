<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('First page');
    }
    
    /**
     * @Route("/news/{slug}")
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
            'comments' => $comments
        ]);
    }
}
