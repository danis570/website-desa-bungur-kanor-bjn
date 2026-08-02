<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Admin;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageHistory;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageOfficial;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageVisionMission;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageHistoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageOfficialRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageVisionMissionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\SessionService;
use Kkn27Unirow\WebsiteDesaBungur\Service\VillageProfileService;

class VillageProfileController
{
    private VillageProfileService $profileService;
    private SessionService $sessionService;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $officialRepository = new VillageOfficialRepository($pdo);
        $historyRepository = new VillageHistoryRepository($pdo);
        $visionMissionRepository = new VillageVisionMissionRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $sessionRepository = new SessionRepository($pdo);

        $this->profileService = new VillageProfileService(
            $officialRepository,
            $historyRepository,
            $visionMissionRepository
        );

        $this->sessionService = new SessionService(
            $sessionRepository,
            $userRepository
        );
    }

    // ==========================================================
    // OFFICIALS
    // ==========================================================

    /**
     * Display list of officials
     */
    public function officials(): void
    {
        $officials = $this->profileService->getAllOfficials();

        View::renderAdmin('VillageProfile/officials', [
            'title' => 'Aparatur Desa',
            'current' => 'officials',
            'user' => $this->sessionService->current(),
            'officials' => $officials,
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => '/admin/dashboard'],
                ['title' => 'Aparatur Desa', 'url' => null]
            ]
        ]);
    }

    public function officialAdd(): void
    {
        View::renderAdmin('VillageProfile/official-add', [
            'title' => 'Tambah Perangkat Desa',
            'current' => 'officials',
            'user' => $this->sessionService->current(),
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => '/admin/dashboard'],

                ['title' => 'Perangkat Desa', 'url' => '/admin/profile/officials'],
                ['title' => 'Tambah', 'url' => null]
            ]
        ]);
    }

    public function postOfficialAdd(): void
    {
        try {
            $official = new VillageOfficial();
            $official->name = trim($_POST['name'] ?? '');
            $official->position = trim($_POST['position'] ?? '');
            $official->period = trim($_POST['period'] ?? '');
            $official->isActive = isset($_POST['is_active']) ? (bool) $_POST['is_active'] : true;
            $official->whatsapp = trim($_POST['whatsapp'] ?? '');
            $official->facebook = trim($_POST['facebook'] ?? '');
            $official->email = trim($_POST['email'] ?? '');
            $official->mapsEmbedUrl = trim($_POST['maps_embed_url'] ?? '');
            $official->address = trim($_POST['address'] ?? '');

            // Handle photo upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $official->photo = $this->uploadImage($_FILES['photo'], 'official');
            }

            $this->profileService->createOfficial($official);
            $_SESSION['success'] = 'Perangkat desa berhasil ditambahkan';
            View::redirect('/admin/profile/officials');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/profile/officials/add');
        }
    }

    public function officialEdit(int $id): void
    {
        try {
            $official = $this->profileService->getOfficialById($id);
            if ($official === null) {
                $_SESSION['error'] = 'Perangkat desa tidak ditemukan';
                View::redirect('/admin/profile/officials');
                return;
            }

            View::renderAdmin('VillageProfile/official-edit', [
                'title' => 'Edit Perangkat Desa',
                'current' => 'officials',
                'user' => $this->sessionService->current(),
                'official' => $official,
                'breadcrumbs' => [
                    ['title' => 'Dashboard', 'url' => '/admin/dashboard'],

                    ['title' => 'Perangkat Desa', 'url' => '/admin/profile/officials'],
                    ['title' => 'Edit', 'url' => null]
                ]
            ]);
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/profile/officials');
        }
    }

    public function postOfficialEdit(int $id): void
    {
        try {
            $existing = $this->profileService->getOfficialById($id);
            if ($existing === null) {
                throw new ValidationException('Perangkat desa tidak ditemukan');
            }

            $official = new VillageOfficial();
            $official->id = $id;
            $official->name = trim($_POST['name'] ?? '');
            $official->position = trim($_POST['position'] ?? '');
            $official->period = trim($_POST['period'] ?? '');
            $official->isActive = isset($_POST['is_active']) ? (bool) $_POST['is_active'] : true;
            $official->whatsapp = trim($_POST['whatsapp'] ?? '');
            $official->facebook = trim($_POST['facebook'] ?? '');
            $official->email = trim($_POST['email'] ?? '');
            $official->mapsEmbedUrl = trim($_POST['maps_embed_url'] ?? '');
            $official->address = trim($_POST['address'] ?? '');

            // Handle photo upload
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                if ($existing->photo) {
                    $this->deleteImage($existing->photo, 'official');
                }
                $official->photo = $this->uploadImage($_FILES['photo'], 'official');
            } else {
                $official->photo = $existing->photo;
            }

            $this->profileService->updateOfficial($official);
            $_SESSION['success'] = 'Perangkat desa berhasil diperbarui';
            View::redirect('/admin/profile/officials');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/profile/officials/edit/' . $id);
        }
    }

    public function postOfficialDelete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $official = $this->profileService->getOfficialById($id);
            if ($official === null) {
                throw new ValidationException('Perangkat desa tidak ditemukan');
            }

            if ($official->photo) {
                $this->deleteImage($official->photo, 'official');
            }

            $this->profileService->deleteOfficial($id);
            $_SESSION['success'] = 'Perangkat desa berhasil dihapus';
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        View::redirect('/admin/profile/officials');
    }

    // ==========================================================
    // HISTORIES
    // ==========================================================
    public function histories(): void
    {
        $histories = $this->profileService->getAllHistories();

        View::renderAdmin('VillageProfile/histories', [
            'title' => 'Sejarah Desa',
            'current' => 'histories',
            'user' => $this->sessionService->current(),
            'histories' => $histories,
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => '/admin/dashboard'],

                ['title' => 'Sejarah Desa', 'url' => null]
            ]
        ]);
    }

    public function historyAdd(): void
    {
        View::renderAdmin('VillageProfile/history-add', [
            'title' => 'Tambah Sejarah Desa',
            'current' => 'histories',
            'user' => $this->sessionService->current(),
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => '/admin/dashboard'],

                ['title' => 'Sejarah Desa', 'url' => '/admin/profile/histories'],
                ['title' => 'Tambah', 'url' => null]
            ]
        ]);
    }

    public function postHistoryAdd(): void
    {
        try {
            $history = new VillageHistory();
            $history->year = (int) ($_POST['year'] ?? 0);
            $history->title = trim($_POST['title'] ?? '');
            $history->description = trim($_POST['description'] ?? '');

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $history->image = $this->uploadImage($_FILES['image'], 'history');
            }

            $this->profileService->createHistory($history);
            $_SESSION['success'] = 'Sejarah desa berhasil ditambahkan';
            View::redirect('/admin/profile/histories');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/profile/histories/add');
        }
    }

    public function historyEdit(int $id): void
    {
        try {
            $history = $this->profileService->getHistoryById($id);
            if ($history === null) {
                $_SESSION['error'] = 'Sejarah desa tidak ditemukan';
                View::redirect('/admin/profile/histories');
                return;
            }

            View::renderAdmin('VillageProfile/history-edit', [
                'title' => 'Edit Sejarah Desa',
                'current' => 'histories',
                'user' => $this->sessionService->current(),
                'history' => $history,
                'breadcrumbs' => [
                    ['title' => 'Dashboard', 'url' => '/admin/dashboard'],

                    ['title' => 'Sejarah Desa', 'url' => '/admin/profile/histories'],
                    ['title' => 'Edit', 'url' => null]
                ]
            ]);
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/profile/histories');
        }
    }

    public function postHistoryEdit(int $id): void
    {
        try {
            $existing = $this->profileService->getHistoryById($id);
            if ($existing === null) {
                throw new ValidationException('Sejarah desa tidak ditemukan');
            }

            $history = new VillageHistory();
            $history->id = $id;
            $history->year = (int) ($_POST['year'] ?? 0);
            $history->title = trim($_POST['title'] ?? '');
            $history->description = trim($_POST['description'] ?? '');

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                if ($existing->image) {
                    $this->deleteImage($existing->image, 'history');
                }
                $history->image = $this->uploadImage($_FILES['image'], 'history');
            } else {
                $history->image = $existing->image;
            }

            $this->profileService->updateHistory($history);
            $_SESSION['success'] = 'Sejarah desa berhasil diperbarui';
            View::redirect('/admin/profile/histories');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/profile/histories/edit/' . $id);
        }
    }

    public function postHistoryDelete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $history = $this->profileService->getHistoryById($id);
            if ($history === null) {
                throw new ValidationException('Sejarah desa tidak ditemukan');
            }

            if ($history->image) {
                $this->deleteImage($history->image, 'history');
            }

            $this->profileService->deleteHistory($id);
            $_SESSION['success'] = 'Sejarah desa berhasil dihapus';
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        View::redirect('/admin/profile/histories');
    }

    // ==========================================================
    // VISIONS & MISSIONS
    // ==========================================================

    public function visionsMissions(): void
    {
        $visions = $this->profileService->getVisions();
        $missions = $this->profileService->getMissions();

        View::renderAdmin('VillageProfile/visions-missions', [
            'title' => 'Visi & Misi Desa',
            'current' => 'visions',
            'user' => $this->sessionService->current(),
            'visions' => $visions,
            'missions' => $missions,
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => '/admin/dashboard'],

                ['title' => 'Visi & Misi', 'url' => null]
            ]
        ]);
    }

    public function visionMissionAdd(): void
    {
        View::renderAdmin('VillageProfile/vision-mission-add', [
            'title' => 'Tambah Visi/Misi',
            'current' => 'visions',
            'user' => $this->sessionService->current(),
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => '/admin/dashboard'],

                ['title' => 'Visi & Misi', 'url' => '/admin/profile/visions-missions'],
                ['title' => 'Tambah', 'url' => null]
            ]
        ]);
    }

    public function postVisionMissionAdd(): void
    {
        try {
            $item = new VillageVisionMission();
            $item->type = $_POST['type'] ?? 'vision';
            $item->description = trim($_POST['description'] ?? '');
            $item->sortOrder = (int) ($_POST['sort_order'] ?? 0);

            $this->profileService->createVisionMission($item);
            $_SESSION['success'] = 'Data visi/misi berhasil ditambahkan';
            View::redirect('/admin/profile/visions-missions');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/profile/visions-missions/add');
        }
    }

    public function visionMissionEdit(int $id): void
    {
        try {
            $item = $this->profileService->getVisionMissionById($id);
            if ($item === null) {
                $_SESSION['error'] = 'Data visi/misi tidak ditemukan';
                View::redirect('/admin/profile/visions-missions');
                return;
            }

            View::renderAdmin('VillageProfile/vision-mission-edit', [
                'title' => 'Edit Visi/Misi',
                'current' => 'visions',
                'user' => $this->sessionService->current(),
                'item' => $item,
                'breadcrumbs' => [
                    ['title' => 'Dashboard', 'url' => '/admin/dashboard'],

                    ['title' => 'Visi & Misi', 'url' => '/admin/profile/visions-missions'],
                    ['title' => 'Edit', 'url' => null]
                ]
            ]);
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/profile/visions-missions');
        }
    }

    public function postVisionMissionEdit(int $id): void
    {
        try {
            $item = new VillageVisionMission();
            $item->id = $id;
            $item->type = $_POST['type'] ?? 'vision';
            $item->description = trim($_POST['description'] ?? '');
            $item->sortOrder = (int) ($_POST['sort_order'] ?? 0);

            $this->profileService->updateVisionMission($item);
            $_SESSION['success'] = 'Data visi/misi berhasil diperbarui';
            View::redirect('/admin/profile/visions-missions');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/profile/visions-missions/edit/' . $id);
        }
    }

    public function postVisionMissionDelete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->profileService->deleteVisionMission($id);
            $_SESSION['success'] = 'Data visi/misi berhasil dihapus';
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        View::redirect('/admin/profile/visions-missions');
    }

    // ==========================================================
    // HELPERS
    // ==========================================================

    private function uploadImage(array $file, string $folder): string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return '';
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return '';
        }

        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            return '';
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $folder . '_' . time() . '_' . uniqid() . '.' . $extension;

        $uploadDir = __DIR__ . '/../../../public/uploads/' . $folder . '/';
        $targetPath = $uploadDir . $filename;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        }

        return '';
    }

    private function deleteImage(?string $filename, string $folder): void
    {
        if (empty($filename)) {
            return;
        }

        $uploadDir = __DIR__ . '/../../../public/uploads/' . $folder . '/';
        $filePath = $uploadDir . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * Get position badge class
     */
    private function getPositionClass(string $position): string
    {
        $map = [
            'Kepala Desa' => 'position-kades',
            'Sekretaris Desa' => 'position-sekdes',
            'Kaur Keuangan' => 'position-kaur',
            'Kaur Umum' => 'position-kaur',
            'Kaur Perencanaan' => 'position-kaur',
            'Kasi Pemerintahan' => 'position-kasi',
            'Kasi Kesejahteraan' => 'position-kasi',
            'Kasi Pelayanan' => 'position-kasi',
            'Staf Desa' => 'position-staf'
        ];

        return $map[$position] ?? 'position-other';
    }
}