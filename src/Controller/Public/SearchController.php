<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Public;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageOfficialRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageHistoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\PhotoRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageGreetingRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageVisionMissionRepository;

class SearchController
{
    private ArticleRepository $articleRepository;
    private UmkmRepository $umkmRepository;
    private VillageOfficialRepository $officialRepository;
    private VillageHistoryRepository $historyRepository;
    private PhotoRepository $photoRepository;
    private VillageGreetingRepository $greetingRepository;
    private VillageVisionMissionRepository $visionMissionRepository;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->articleRepository = new ArticleRepository($pdo);
        $this->umkmRepository = new UmkmRepository($pdo);
        $this->officialRepository = new VillageOfficialRepository($pdo);
        $this->historyRepository = new VillageHistoryRepository($pdo);
        $this->photoRepository = new PhotoRepository($pdo);
        $this->greetingRepository = new VillageGreetingRepository($pdo);
        $this->visionMissionRepository = new VillageVisionMissionRepository($pdo);
    }

    /**
     * Search API - Returns JSON results for AJAX request
     */
    public function search(): void
    {
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (strlen($query) < 2) {
            header('Content-Type: application/json');
            echo json_encode(['results' => []]);
            return;
        }

        $results = [];

        try {
            // 1. ARTIKEL (Berita)
            $articles = $this->articleRepository->findPublished();
            foreach ($articles as $article) {
                if (
                    stripos($article->title ?? '', $query) !== false ||
                    stripos($article->content ?? '', $query) !== false ||
                    stripos($article->excerpt ?? '', $query) !== false
                ) {
                    $results[] = [
                        'type' => 'Berita',
                        'title' => $article->title ?? 'Tanpa Judul',
                        'description' => substr(strip_tags($article->excerpt ?? $article->content ?? ''), 0, 100),
                        'url' => '/kabar/detail/' . ($article->slug ?? ''),
                        'image' => '/uploads/articles/' . ($article->image ?? 'default-news.jpg'),
                    ];
                }
            }

            // 2. UMKM
            $umkms = $this->umkmRepository->findAll();
            foreach ($umkms as $umkm) {
                if (
                    stripos($umkm->name ?? '', $query) !== false ||
                    stripos($umkm->owner ?? '', $query) !== false ||
                    stripos($umkm->description ?? '', $query) !== false
                ) {
                    $results[] = [
                        'type' => 'UMKM',
                        'title' => $umkm->name ?? 'Tanpa Nama',
                        'description' => 'Pemilik: ' . ($umkm->owner ?? 'Tidak diketahui') . ($umkm->categoryName ? ' | ' . $umkm->categoryName : ''),
                        'url' => '/umkm/detail/' . ($umkm->slug ?? ''),
                        'image' => '/uploads/umkm/' . ($umkm->featuredImage ?? 'default-umkm.jpg'),
                    ];
                }
            }

            // 3. APARATUR DESA
            $officials = $this->officialRepository->findAll();
            foreach ($officials as $official) {
                if (
                    stripos($official->name ?? '', $query) !== false ||
                    stripos($official->position ?? '', $query) !== false
                ) {
                    $results[] = [
                        'type' => 'Aparatur Desa',
                        'title' => $official->name ?? 'Tanpa Nama',
                        'description' => ($official->position ?? 'Jabatan') . ' | Periode: ' . ($official->period ?? ''),
                        'url' => '/profil/aparatur',
                        'image' => $official->photo ? '/uploads/official/' . $official->photo : null,
                    ];
                }
            }

            // 4. SEJARAH DESA
            $histories = $this->historyRepository->findAll();
            foreach ($histories as $history) {
                if (
                    stripos($history->title ?? '', $query) !== false ||
                    stripos($history->description ?? '', $query) !== false
                ) {
                    $results[] = [
                        'type' => 'Sejarah Desa',
                        'title' => ($history->title ?? '') . ' (' . ($history->year ?? '') . ')',
                        'description' => substr(strip_tags($history->description ?? ''), 0, 100),
                        'url' => '/profie/sejarah',
                        'image' => $history->image ? '/uploads/history/' . $history->image : null,
                    ];
                }
            }

            // 5. GALERI FOTO
            $photos = $this->photoRepository->findAll();
            foreach ($photos as $photo) {
                if (
                    stripos($photo->caption ?? '', $query) !== false ||
                    stripos($photo->location ?? '', $query) !== false
                ) {
                    $results[] = [
                        'type' => 'Galeri Foto',
                        'title' => $photo->caption ?: 'Foto Desa',
                        'description' => 'Lokasi: ' . ($photo->location ?? 'Tidak diketahui'),
                        'url' => '/photo',
                        'image' => '/uploads/photos/' . ($photo->image ?? 'default-photo.jpg'),
                    ];
                }
            }

            // 6. SAMBUTAN KEPALA DESA
            $greetings = $this->greetingRepository->findAll();
            foreach ($greetings as $greeting) {
                if (
                    stripos($greeting->name ?? '', $query) !== false ||
                    stripos($greeting->content ?? '', $query) !== false
                ) {
                    $results[] = [
                        'type' => 'Sambutan',
                        'title' => 'Sambutan ' . ($greeting->name ?? 'Kepala Desa'),
                        'description' => substr(strip_tags($greeting->content ?? ''), 0, 100),
                        'url' => '/#sambutan',
                        'image' => $greeting->image ? '/uploads/greeting/' . $greeting->image : null,
                    ];
                }
            }

            // 7. VISI & MISI
            $visionMissions = $this->visionMissionRepository->findAll();
            foreach ($visionMissions as $item) {
                if (stripos($item->description ?? '', $query) !== false) {
                    $type = $item->type === 'vision' ? 'Visi' : 'Misi';
                    $results[] = [
                        'type' => 'Visi & Misi',
                        'title' => $type . ' Desa Bungur',
                        'description' => substr(strip_tags($item->description ?? ''), 0, 100),
                        'url' => '/#visi-misi',
                        'image' => null,
                    ];
                }
            }

        } catch (\Exception $e) {
            error_log('Search error: ' . $e->getMessage());
        }

        // Limit results to 10
        $results = array_slice($results, 0, 10);

        header('Content-Type: application/json');
        echo json_encode(['results' => $results]);
    }

    /**
     * Search Results Page
     */
    public function results(): void
    {
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';

        $searchResults = [];
        $totalResults = 0;

        try {
            if (strlen($query) >= 2) {
                $results = [];

                // 1. ARTIKEL
                $articles = $this->articleRepository->findPublished();
                foreach ($articles as $article) {
                    if (
                        stripos($article->title ?? '', $query) !== false ||
                        stripos($article->content ?? '', $query) !== false
                    ) {
                        $results[] = [
                            'type' => 'Berita',
                            'title' => $article->title ?? 'Tanpa Judul',
                            'description' => substr(strip_tags($article->excerpt ?? $article->content ?? ''), 0, 150),
                            'url' => '/kabar/detail/' . ($article->slug ?? ''),
                            'date' => $article->publishedAt ?? $article->createdAt,
                            'image' => '/uploads/articles/' . ($article->image ?? 'default-news.jpg'),
                        ];
                    }
                }

                // 2. UMKM
                $umkms = $this->umkmRepository->findAll();
                foreach ($umkms as $umkm) {
                    if (
                        stripos($umkm->name ?? '', $query) !== false ||
                        stripos($umkm->owner ?? '', $query) !== false
                    ) {
                        $results[] = [
                            'type' => 'UMKM',
                            'title' => $umkm->name ?? 'Tanpa Nama',
                            'description' => 'Pemilik: ' . ($umkm->owner ?? 'Tidak diketahui') . ($umkm->categoryName ? ' | ' . $umkm->categoryName : ''),
                            'url' => '/umkm/detail/' . ($umkm->slug ?? ''),
                            'date' => $umkm->createdAt,
                            'image' => '/uploads/umkm/' . ($umkm->featuredImage ?? 'default-umkm.jpg'),
                        ];
                    }
                }

                // 3. APARATUR
                $officials = $this->officialRepository->findAll();
                foreach ($officials as $official) {
                    if (
                        stripos($official->name ?? '', $query) !== false ||
                        stripos($official->position ?? '', $query) !== false
                    ) {
                        $results[] = [
                            'type' => 'Aparatur Desa',
                            'title' => $official->name ?? 'Tanpa Nama',
                            'description' => ($official->position ?? 'Jabatan') . ' | Periode: ' . ($official->period ?? ''),
                            'url' => '/profil/aparatur',
                            'date' => $official->createdAt,
                            'image' => $official->photo ? '/uploads/official/' . $official->photo : null,
                        ];
                    }
                }

                // 4. SEJARAH
                $histories = $this->historyRepository->findAll();
                foreach ($histories as $history) {
                    if (
                        stripos($history->title ?? '', $query) !== false ||
                        stripos($history->description ?? '', $query) !== false
                    ) {
                        $results[] = [
                            'type' => 'Sejarah Desa',
                            'title' => ($history->title ?? '') . ' (' . ($history->year ?? '') . ')',
                            'description' => substr(strip_tags($history->description ?? ''), 0, 150),
                            'url' => '/profil/sejarah',
                            'date' => $history->createdAt,
                            'image' => $history->image ? '/uploads/history/' . $history->image : null,
                        ];
                    }
                }

                // 5. GALERI FOTO
                $photos = $this->photoRepository->findAll();
                foreach ($photos as $photo) {
                    if (
                        stripos($photo->caption ?? '', $query) !== false ||
                        stripos($photo->location ?? '', $query) !== false
                    ) {
                        $results[] = [
                            'type' => 'Galeri Foto',
                            'title' => $photo->caption ?: 'Foto Desa',
                            'description' => 'Lokasi: ' . ($photo->location ?? 'Tidak diketahui'),
                            'url' => '/photo',
                            'date' => $photo->createdAt,
                            'image' => '/uploads/photos/' . ($photo->image ?? 'default-photo.jpg'),
                        ];
                    }
                }

                // 6. SAMBUTAN
                $greetings = $this->greetingRepository->findAll();
                foreach ($greetings as $greeting) {
                    if (
                        stripos($greeting->name ?? '', $query) !== false ||
                        stripos($greeting->content ?? '', $query) !== false
                    ) {
                        $results[] = [
                            'type' => 'Sambutan',
                            'title' => 'Sambutan ' . ($greeting->name ?? 'Kepala Desa'),
                            'description' => substr(strip_tags($greeting->content ?? ''), 0, 150),
                            'url' => '/#sambutan',
                            'date' => $greeting->createdAt,
                            'image' => $greeting->image ? '/uploads/greeting/' . $greeting->image : null,
                        ];
                    }
                }

                // 7. VISI & MISI
                $visionMissions = $this->visionMissionRepository->findAll();
                foreach ($visionMissions as $item) {
                    if (stripos($item->description ?? '', $query) !== false) {
                        $type = $item->type === 'vision' ? 'Visi' : 'Misi';
                        $results[] = [
                            'type' => 'Visi & Misi',
                            'title' => $type . ' Desa Bungur',
                            'description' => substr(strip_tags($item->description ?? ''), 0, 150),
                            'url' => '/#visi-misi',
                            'date' => $item->createdAt,
                            'image' => null,
                        ];
                    }
                }

                $searchResults = $results;
                $totalResults = count($results);
            }
        } catch (\Exception $e) {
            error_log('Search results error: ' . $e->getMessage());
        }

        View::renderPublic('Search/results', [
            'title' => 'Hasil Pencarian: ' . $query,
            'current' => 'search',
            'query' => $query,
            'results' => $searchResults,
            'totalResults' => $totalResults
        ]);
    }
}