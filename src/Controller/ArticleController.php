<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Psr\Log\LoggerInterface;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class ArticleController extends AbstractController
{
    private $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();
        return $this->render('articles/homepage.html.twig', [
            'articles'=>$articles
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, MarkdownHelper $markdownHelper, SlackClient $slack, ArticleRepository $repository)
    {
        if ($slug === 'khaaaaaan') {
            $slack->sendMessage('Khan', 'Ah, Kirk, my old friend...');
        }

        /** @var Article $article */
        $article = $repository->findOneBy(['slug' => $slug]);
        if (!$article) {
            throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
        }

        $comments = [
            'Comment line 1',
            'Comment line 2',
            'Comment line 3'
        ];

        return $this->render('articles/show.html.twig', [
            'title' => ucwords(str_replace("-", " ", $slug)),
            'slug' => $slug,
            'article' => $article,
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
