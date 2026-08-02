<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Admin;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Domain\HeroBanner;
use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageGreeting;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Repository\HeroBannerRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\VillageGreetingRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\LandingPageService;
use Kkn27Unirow\WebsiteDesaBungur\Service\SessionService;

class LandingPageController
{
    private LandingPageService $landingService;
    private SessionService $sessionService;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $bannerRepository = new HeroBannerRepository($pdo);
        $greetingRepository = new VillageGreetingRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $sessionRepository = new SessionRepository($pdo);

        $this->landingService = new LandingPageService(
            $bannerRepository,
            $greetingRepository
        );

        $this->sessionService = new SessionService(
            $sessionRepository,
            $userRepository
        );
    }
    
    // ==========================================================
    // HERO BANNERS
    // ==========================================================

    public function banners(): void
    {
        $banners = $this->landingService->getAllBanners();

        View::renderAdmin('LandingPage/banners', [
            'title' => 'Hero Banners',
            'current' => 'landing-banners',
            'user' => $this->sessionService->current(),
            'banners' => $banners,
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => '/admin/dashboard'],
                ['title' => 'Landing Page', 'url' => '/admin/landing'],
                ['title' => 'Hero Banners', 'url' => null]
            ]
        ]);
    }

    public function bannerAdd(): void
    {
        View::renderAdmin('LandingPage/banner-add', [
            'title' => 'Tambah Hero Banner',
            'current' => 'landing-banners',
            'user' => $this->sessionService->current(),
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => '/admin/dashboard'],
                ['title' => 'Landing Page', 'url' => '/admin/landing'],
                ['title' => 'Hero Banners', 'url' => '/admin/landing/banners'],
                ['title' => 'Tambah', 'url' => null]
            ]
        ]);
    }

    public function postBannerAdd(): void
    {
        try {
            $banner = new HeroBanner();
            $banner->title = trim($_POST['title'] ?? '');
            $banner->description = trim($_POST['description'] ?? '');

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $banner->image = $this->uploadImage($_FILES['image'], 'banner');
            } else {
                throw new ValidationException('Gambar banner wajib diupload');
            }

            $this->landingService->createBanner($banner);
            $_SESSION['success'] = 'Hero banner berhasil ditambahkan';
            View::redirect('/admin/landing/banners');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/landing/banners/add');
        }
    }

    public function bannerEdit(int $id): void
    {
        try {
            $banner = $this->landingService->getBannerById($id);
            if ($banner === null) {
                $_SESSION['error'] = 'Banner tidak ditemukan';
                View::redirect('/admin/landing/banners');
                return;
            }

            View::renderAdmin('LandingPage/banner-edit', [
                'title' => 'Edit Hero Banner',
                'current' => 'landing-banners',
                'user' => $this->sessionService->current(),
                'banner' => $banner,
                'breadcrumbs' => [
                    ['title' => 'Dashboard', 'url' => '/admin/dashboard'],
                    ['title' => 'Landing Page', 'url' => '/admin/landing'],
                    ['title' => 'Hero Banners', 'url' => '/admin/landing/banners'],
                    ['title' => 'Edit', 'url' => null]
                ]
            ]);
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/landing/banners');
        }
    }

    public function postBannerEdit(int $id): void
    {
        try {
            $existing = $this->landingService->getBannerById($id);
            if ($existing === null) {
                throw new ValidationException('Banner tidak ditemukan');
            }

            $banner = new HeroBanner();
            $banner->id = $id;
            $banner->title = trim($_POST['title'] ?? '');
            $banner->description = trim($_POST['description'] ?? '');
            $banner->image = $existing->image;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Hapus gambar lama
                if ($existing->image) {
                    $this->deleteImage($existing->image, 'banner');
                }
                $banner->image = $this->uploadImage($_FILES['image'], 'banner');
            }

            $this->landingService->updateBanner($banner);
            $_SESSION['success'] = 'Hero banner berhasil diperbarui';
            View::redirect('/admin/landing/banners');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/landing/banners/edit/' . $id);
        }
    }

    public function postBannerDelete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->landingService->deleteBanner($id);
            $_SESSION['success'] = 'Hero banner berhasil dihapus';
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        View::redirect('/admin/landing/banners');
    }

    // ==========================================================
    // VILLAGE GREETINGS
    // ==========================================================

    public function greetings(): void
    {
        $greetings = $this->landingService->getAllGreetings();

        View::renderAdmin('LandingPage/greetings', [
            'title' => 'Sambutan Kepala Desa',
            'current' => 'landing-greetings',
            'user' => $this->sessionService->current(),
            'greetings' => $greetings,
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => '/admin/dashboard'],
                ['title' => 'Landing Page', 'url' => '/admin/landing'],
                ['title' => 'Sambutan', 'url' => null]
            ]
        ]);
    }

    public function greetingAdd(): void
    {
        View::renderAdmin('LandingPage/greeting-add', [
            'title' => 'Tambah Sambutan',
            'current' => 'landing-greetings',
            'user' => $this->sessionService->current(),
            'breadcrumbs' => [
                ['title' => 'Dashboard', 'url' => '/admin/dashboard'],
                ['title' => 'Landing Page', 'url' => '/admin/landing'],
                ['title' => 'Sambutan', 'url' => '/admin/landing/greetings'],
                ['title' => 'Tambah', 'url' => null]
            ]
        ]);
    }

    public function postGreetingAdd(): void
    {
        try {
            $greeting = new VillageGreeting();
            $greeting->name = trim($_POST['name'] ?? '');
            $greeting->opening = trim($_POST['opening'] ?? '');
            $greeting->content = trim($_POST['content'] ?? '');
            $greeting->closing = trim($_POST['closing'] ?? '');

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $greeting->image = $this->uploadImage($_FILES['image'], 'greeting');
            }

            if (isset($_FILES['signature_image']) && $_FILES['signature_image']['error'] === UPLOAD_ERR_OK) {
                $greeting->signatureImage = $this->uploadImage($_FILES['signature_image'], 'signature');
            }

            $this->landingService->createGreeting($greeting);
            $_SESSION['success'] = 'Sambutan berhasil ditambahkan';
            View::redirect('/admin/landing/greetings');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/landing/greetings/add');
        }
    }

    public function greetingEdit(int $id): void
    {
        try {
            $greeting = $this->landingService->getGreetingById($id);
            if ($greeting === null) {
                $_SESSION['error'] = 'Sambutan tidak ditemukan';
                View::redirect('/admin/landing/greetings');
                return;
            }

            View::renderAdmin('LandingPage/greeting-edit', [
                'title' => 'Edit Sambutan',
                'current' => 'landing-greetings',
                'user' => $this->sessionService->current(),
                'greeting' => $greeting,
                'breadcrumbs' => [
                    ['title' => 'Dashboard', 'url' => '/admin/dashboard'],
                    ['title' => 'Landing Page', 'url' => '/admin/landing'],
                    ['title' => 'Sambutan', 'url' => '/admin/landing/greetings'],
                    ['title' => 'Edit', 'url' => null]
                ]
            ]);
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/landing/greetings');
        }
    }

    public function postGreetingEdit(int $id): void
    {
        try {
            $existing = $this->landingService->getGreetingById($id);
            if ($existing === null) {
                throw new ValidationException('Sambutan tidak ditemukan');
            }

            $greeting = new VillageGreeting();
            $greeting->id = $id;
            $greeting->name = trim($_POST['name'] ?? '');
            $greeting->opening = trim($_POST['opening'] ?? '');
            $greeting->content = trim($_POST['content'] ?? '');
            $greeting->closing = trim($_POST['closing'] ?? '');
            $greeting->image = $existing->image;
            $greeting->signatureImage = $existing->signatureImage;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                if ($existing->image) {
                    $this->deleteImage($existing->image, 'greeting');
                }
                $greeting->image = $this->uploadImage($_FILES['image'], 'greeting');
            }

            if (isset($_FILES['signature_image']) && $_FILES['signature_image']['error'] === UPLOAD_ERR_OK) {
                if ($existing->signatureImage) {
                    $this->deleteImage($existing->signatureImage, 'signature');
                }
                $greeting->signatureImage = $this->uploadImage($_FILES['signature_image'], 'signature');
            }

            $this->landingService->updateGreeting($greeting);
            $_SESSION['success'] = 'Sambutan berhasil diperbarui';
            View::redirect('/admin/landing/greetings');
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/landing/greetings/edit/' . $id);
        }
    }

    public function postGreetingDelete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->landingService->deleteGreeting($id);
            $_SESSION['success'] = 'Sambutan berhasil dihapus';
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        View::redirect('/admin/landing/greetings');
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
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            return '';
        }

        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            return '';
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $folder . '_' . time() . '_' . uniqid() . '.' . $extension;

        $uploadDir = __DIR__ . '/../../../public/uploads/' . $folder . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $targetPath = $uploadDir . $filename;

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
}