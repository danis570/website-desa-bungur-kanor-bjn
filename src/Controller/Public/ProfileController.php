<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Public;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Repository\PhotoRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageGreetingRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageHistoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageOfficialRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageVisionMissionRepository;

class ProfileController
{
    private VillageOfficialRepository $officialRepository;
    private VillageHistoryRepository $historyRepository;
    private VillageVisionMissionRepository $visionMissionRepository;
    private VillageGreetingRepository $greetingRepository;
    private PhotoRepository $photoRepository;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $this->officialRepository = new VillageOfficialRepository($pdo);
        $this->historyRepository = new VillageHistoryRepository($pdo);
        $this->visionMissionRepository = new VillageVisionMissionRepository($pdo);
        $this->greetingRepository = new VillageGreetingRepository($pdo);
        $this->photoRepository = new PhotoRepository($pdo);
    }

    /**
     * Profile utama - menampilkan visi misi, sejarah, aparatur, dan galeri
     */
    public function profile(): void
    {
        // Get visions & missions
        $visions = $this->visionMissionRepository->findByType('vision');
        $missions = $this->visionMissionRepository->findByType('mission');

        // Get first greeting
        $greeting = $this->greetingRepository->findFirst();

        // Get active officials
        $activeOfficials = $this->officialRepository->findActive();

        // Get histories (limit 4)
        $histories = $this->historyRepository->findAll();
        $latestHistories = array_slice($histories, 0, 4);

        // Get photos for gallery (limit 6)
        $photos = $this->photoRepository->findAll();
        $galleryPhotos = array_slice($photos, 0, 6);

        View::renderPublic('Profile/profile', [
            'title' => 'Profil Desa',
            'current' => 'profile',
            'visions' => $visions,
            'missions' => $missions,
            'greeting' => $greeting,
            'activeOfficials' => $activeOfficials,
            'latestHistories' => $latestHistories,
            'galleryPhotos' => $galleryPhotos
        ]);
    }

    /**
     * Aparatur Desa Aktif
     */
    public function apparatusActive(): void
    {
        $officials = $this->officialRepository->findActive();

        View::renderPublic('Profile/village-apparatus', [
            'title' => 'Aparatur Desa Aktif',
            'current' => 'profile',
            'officials' => $officials
        ]);
    }

    /**
     * Aparatur Desa Lengkap (Semua)
     */
    public function apparatusHistory(): void
    {
        $officials = $this->officialRepository->findAll();

        View::renderPublic('Profile/village-apparatus-history', [
            'title' => 'Aparatur Desa Lengkap',
            'current' => 'profile',
            'officials' => $officials
        ]);
    }

    /**
     * Sejarah Desa Lengkap
     */
    public function history(): void
    {
        $histories = $this->historyRepository->findAll();

        View::renderPublic('Profile/village-history', [
            'title' => 'Sejarah Desa',
            'current' => 'profile',
            'histories' => $histories
        ]);
    }
}