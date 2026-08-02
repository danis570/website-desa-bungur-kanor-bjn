<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Public;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmMenuRepository;

class UmkmController
{
    private UmkmRepository $umkmRepository;
    private UmkmMenuRepository $menuRepository;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->umkmRepository = new UmkmRepository($pdo);
        $this->menuRepository = new UmkmMenuRepository($pdo);
    }

    /**
     * Display list of UMKM
     */
    public function index(): void
    {
        // Get all UMKM
        $umkms = $this->umkmRepository->findAll();

        // Load menus for each UMKM
        foreach ($umkms as $umkm) {
            $umkm->menus = $this->menuRepository->findByUmkmId($umkm->id);
        }

        View::renderPublic('MSMEs/msme', [
            'title' => 'UMKM Desa Bungur',
            'current' => 'msme',
            'umkms' => $umkms
        ]);
    }

    /**
     * Display UMKM detail by slug
     */
    public function detail(string $slug): void
    {
        $umkm = $this->umkmRepository->findBySlug($slug);

        if ($umkm === null) {
            View::redirect('/umkm');
            return;
        }

        // Load menus
        $umkm->menus = $this->menuRepository->findByUmkmId($umkm->id);

        // Get other UMKM for related
        $allUmkms = $this->umkmRepository->findAll();
        $relatedUmkms = array_filter($allUmkms, function($u) use ($umkm) {
            return $u->id !== $umkm->id;
        });
        $relatedUmkms = array_slice(array_values($relatedUmkms), 0, 4);

        View::renderPublic('MSMEs/msme-detail', [
            'title' => $umkm->name,
            'current' => 'msme',
            'umkm' => $umkm,
            'relatedUmkms' => $relatedUmkms
        ]);
    }
}