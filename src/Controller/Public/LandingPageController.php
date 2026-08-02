<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Public;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\HeroBannerRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\PhotoRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageGreetingRepository;

class LandingPageController
{
    private HeroBannerRepository $bannerRepository;
    private VillageGreetingRepository $greetingRepository;
    private ArticleRepository $articleRepository;
    private PhotoRepository $photoRepository;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $this->bannerRepository = new HeroBannerRepository($pdo);
        $this->greetingRepository = new VillageGreetingRepository($pdo);
        $this->articleRepository = new ArticleRepository($pdo);
        $this->photoRepository = new PhotoRepository($pdo);
    }

    public function index(): void
    {
        // Get all active banners
        $banners = $this->bannerRepository->findAll();
        
        // Get first greeting
        $greeting = $this->greetingRepository->findFirst();

        // Get latest articles (limit 4)
        $articles = $this->articleRepository->findPublished();
        $latestArticles = array_slice($articles, 0, 4);

        // Get latest photos (limit 1 for gallery preview)
        $photos = $this->photoRepository->findAll();
        $latestPhoto = !empty($photos) ? $photos[0] : null;

        View::renderPublicHome([
            'title' => 'Desa Bungur',
            'current' => '',
            'banners' => $banners,
            'greeting' => $greeting,
            'latestArticles' => $latestArticles,
            'latestPhoto' => $latestPhoto,
            'totalPhotos' => count($photos)
        ]);
    }
}