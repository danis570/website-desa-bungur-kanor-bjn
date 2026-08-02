<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Public;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleRepository;

class NewsController
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->articleRepository = new ArticleRepository($pdo);
    }

    /**
     * Display list of all articles (published only)
     */
    public function index(): void
    {
        $articles = $this->articleRepository->findPublished();

        View::renderPublic('News/village-news', [
            'title' => 'Kabar Desa',
            'current' => 'village-news',
            'articles' => $articles
        ]);
    }

    /**
     * Display article detail by slug
     */
    public function detail(string $slug): void
    {
        $article = $this->articleRepository->findBySlug($slug);

        if ($article === null || $article->status !== 'published') {
            View::redirect('/news');
            return;
        }

        // Get related articles (same category, exclude current)
        $allArticles = $this->articleRepository->findPublished();
        $relatedArticles = array_filter($allArticles, function ($a) use ($article) {
            return $a->id !== $article->id && $a->categoryId === $article->categoryId;
        });
        $relatedArticles = array_slice(array_values($relatedArticles), 0, 4);

        // Get article archives (group by month/year)
        $archives = $this->getArticleArchives();

        View::renderPublic('News/village-news-detail', [
            'title' => $article->title,
            'current' => 'village-news',
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'archives' => $archives
        ]);
    }

    /**
     * Display articles archive by month/year
     */
    public function archive(): void
    {
        $month = isset($_GET['month']) ? (int) $_GET['month'] : null;
        $year = isset($_GET['year']) ? (int) $_GET['year'] : null;

        $articles = $this->articleRepository->findPublished();

        // Filter by month/year if provided
        if ($month && $year) {
            $articles = array_filter($articles, function ($article) use ($month, $year) {
                $date = strtotime($article->publishedAt ?? $article->createdAt);
                return (int) date('m', $date) === $month && (int) date('Y', $date) === $year;
            });
        }

        // Get archives for sidebar
        $archives = $this->getArticleArchives();

        // Get month/year name for title
        $archiveTitle = 'Semua Arsip';
        if ($month && $year) {
            $monthName = date('F', mktime(0, 0, 0, $month, 1, $year));
            $archiveTitle = $monthName . ' ' . $year;
        }

        View::renderPublic('News/village-news-archive', [
            'title' => 'Arsip Artikel',
            'current' => 'village-news',
            'articles' => $articles,
            'archives' => $archives,
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'archiveTitle' => $archiveTitle
        ]);
    }

    /**
     * Display articles by author
     */
    public function author(string $authorName): void
    {
         $authorName = urldecode($authorName);
        $articles = $this->articleRepository->findPublished();

        // Filter by author name (case insensitive)
        $authorArticles = array_filter($articles, function ($article) use ($authorName) {
            return strtolower($article->authorName ?? '') === strtolower($authorName);
        });
        $authorArticles = array_values($authorArticles);

        // Get archives for sidebar
        $archives = $this->getArticleArchives();

        // Get author info (ambil dari artikel pertama)
        $authorInfo = null;
        if (!empty($authorArticles)) {
            $first = $authorArticles[0];
            $authorInfo = (object) [
                'name' => $first->authorName,
                'position' => $first->authorPosition,
                'avatar' => $first->authorAvatar,
            ];
        }

        View::renderPublic('News/village-news-author', [
            'title' => 'Artikel oleh ' . $authorName,
            'current' => 'village-news',
            'articles' => $authorArticles,
            'archives' => $archives,
            'authorName' => $authorName,
            'authorInfo' => $authorInfo,
        ]);
    }

    /**
     * Get article archives grouped by month/year
     */
    private function getArticleArchives(): array
    {
        $articles = $this->articleRepository->findPublished();
        $archives = [];

        foreach ($articles as $article) {
            $date = strtotime($article->publishedAt ?? $article->createdAt);
            $month = date('m', $date);
            $year = date('Y', $date);
            $key = $year . '-' . $month;

            if (!isset($archives[$key])) {
                $archives[$key] = [
                    'month' => $month,
                    'year' => $year,
                    'month_name' => date('F', $date),
                    'count' => 0
                ];
            }
            $archives[$key]['count']++;
        }

        // Sort by year desc, month desc
        krsort($archives);

        return array_values($archives);
    }
}