<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\Admin;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\UmkmCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UmkmUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmMenuRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UmkmRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\SessionService;
use Kkn27Unirow\WebsiteDesaBungur\Service\UmkmService;

class UmkmController
{
    private UmkmService $umkmService;
    private SessionService $sessionService;
    private UmkmCategoryRepository $categoryRepository;
    private UmkmMenuRepository $menuRepository;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $umkmRepository = new UmkmRepository($pdo);
        $this->categoryRepository = new UmkmCategoryRepository($pdo);
        $this->menuRepository = new UmkmMenuRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $sessionRepository = new SessionRepository($pdo);

        $this->umkmService = new UmkmService(
            $umkmRepository,
            $this->categoryRepository,
            $this->menuRepository
        );

        $this->sessionService = new SessionService(
            $sessionRepository,
            $userRepository
        );
    }

    /**
     * Display list of UMKM
     */
    public function index(): void
    {
        $umkms = $this->umkmService->findAll();
        $categories = $this->categoryRepository->findAll();

        View::renderAdmin('MSMEs/umkm', [
            'title' => 'UMKM Management',
            'current' => 'umkm',
            'user' => $this->sessionService->current(),
            'umkms' => $umkms,
            'categories' => $categories,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => '/admin/dashboard'
                ],
                [
                    'title' => 'UMKM Management',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Show create UMKM form
     */
    public function add(): void
    {
        $categories = $this->categoryRepository->findAll();

        View::renderAdmin('MSMEs/create', [
            'title' => 'Tambah UMKM',
            'current' => 'umkm',
            'user' => $this->sessionService->current(),
            'categories' => $categories,
            'old' => [],
            'breadcrumbs' => [
                [
                    'title' => 'UMKM Management',
                    'url' => '/admin/umkm'
                ],
                [
                    'title' => 'Tambah UMKM',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Handle create UMKM submission
     */
    public function postAdd(): void
    {
        $request = new UmkmCreateRequest();

        $request->categoryId = (int) ($_POST['category_id'] ?? 0);
        $request->name = trim($_POST['name'] ?? '');
        $request->owner = trim($_POST['owner'] ?? '');
        $request->description = trim($_POST['description'] ?? '');
        $request->address = trim($_POST['address'] ?? '');
        $request->businessHours = trim($_POST['business_hours'] ?? '');
        $request->whatsapp = trim($_POST['whatsapp'] ?? '');
        $request->mapsEmbedUrl = trim($_POST['maps_embed_url'] ?? '');
        $request->featuredImageAlt = trim($_POST['featured_image_alt'] ?? ''); // <-- TAMBAHKAN
        $request->ownerPhotoAlt = trim($_POST['owner_photo_alt'] ?? ''); // <-- TAMBAHKAN

        // Handle menus
        $menus = [];
        if (isset($_POST['menu_name']) && is_array($_POST['menu_name'])) {
            foreach ($_POST['menu_name'] as $index => $name) {
                $name = trim($name);
                if (!empty($name) && isset($_POST['menu_price'][$index]) && !empty(trim($_POST['menu_price'][$index]))) {
                    $price = trim($_POST['menu_price'][$index]);
                    $price = preg_replace('/[^0-9]/', '', $price);
                    
                    $menuImage = null;
                    if (isset($_FILES['menu_image']) && isset($_FILES['menu_image']['tmp_name'][$index]) && $_FILES['menu_image']['error'][$index] === UPLOAD_ERR_OK) {
                        $menuImage = $this->uploadMenuImage([
                            'name' => $_FILES['menu_image']['name'][$index],
                            'tmp_name' => $_FILES['menu_image']['tmp_name'][$index],
                            'type' => $_FILES['menu_image']['type'][$index],
                            'size' => $_FILES['menu_image']['size'][$index],
                            'error' => $_FILES['menu_image']['error'][$index]
                        ]);
                    }
                    
                    $menus[] = [
                        'name' => $name,
                        'price' => (float) $price,
                        'image' => $menuImage
                    ];
                }
            }
        }
        $request->menus = $menus;

        // Handle featured image upload
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $request->featuredImage = $this->uploadImage($_FILES['featured_image'], 'featured');
        }

        // Handle owner photo upload
        if (isset($_FILES['owner_photo']) && $_FILES['owner_photo']['error'] === UPLOAD_ERR_OK) {
            $request->ownerPhoto = $this->uploadImage($_FILES['owner_photo'], 'owner');
        }

        try {
            $this->umkmService->create($request);
            $_SESSION['success'] = 'UMKM berhasil ditambahkan';
            View::redirect('/admin/umkm');
        } catch (ValidationException $e) {
            $categories = $this->categoryRepository->findAll();

            View::renderAdmin('MSMEs/create', [
                'title' => 'Tambah UMKM',
                'current' => 'umkm',
                'user' => $this->sessionService->current(),
                'categories' => $categories,
                'error' => $e->getMessage(),
                'old' => $_POST,
                'breadcrumbs' => [
                    [
                        'title' => 'UMKM Management',
                        'url' => '/admin/umkm'
                    ],
                    [
                        'title' => 'Tambah UMKM',
                        'url' => null
                    ]
                ]
            ]);
        }
    }

    /**
     * Show edit UMKM form
     */
    public function edit(int $id): void
    {
        try {
            $umkm = $this->umkmService->findById($id);
            $categories = $this->categoryRepository->findAll();

            if ($umkm === null) {
                $_SESSION['error'] = 'UMKM tidak ditemukan';
                View::redirect('/admin/umkm');
                return;
            }

            View::renderAdmin('MSMEs/edit', [
                'title' => 'Edit UMKM',
                'current' => 'umkm',
                'user' => $this->sessionService->current(),
                'umkm' => $umkm,
                'categories' => $categories,
                'breadcrumbs' => [
                    [
                        'title' => 'UMKM Management',
                        'url' => '/admin/umkm'
                    ],
                    [
                        'title' => 'Edit UMKM',
                        'url' => null
                    ]
                ]
            ]);
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
            View::redirect('/admin/umkm');
        }
    }

    /**
     * Handle edit UMKM submission
     */
    public function postEdit(int $id): void
    {
        $request = new UmkmUpdateRequest();

        $request->id = $id;
        $request->categoryId = (int) ($_POST['category_id'] ?? 0);
        $request->name = trim($_POST['name'] ?? '');
        $request->owner = trim($_POST['owner'] ?? '');
        $request->description = trim($_POST['description'] ?? '');
        $request->address = trim($_POST['address'] ?? '');
        $request->businessHours = trim($_POST['business_hours'] ?? '');
        $request->whatsapp = trim($_POST['whatsapp'] ?? '');
        $request->mapsEmbedUrl = trim($_POST['maps_embed_url'] ?? '');
        $request->featuredImageAlt = trim($_POST['featured_image_alt'] ?? ''); // <-- TAMBAHKAN
        $request->ownerPhotoAlt = trim($_POST['owner_photo_alt'] ?? ''); // <-- TAMBAHKAN

        // Handle menus
        $menus = [];
        if (isset($_POST['menu_name']) && is_array($_POST['menu_name'])) {
            foreach ($_POST['menu_name'] as $index => $name) {
                $name = trim($name);
                if (!empty($name) && isset($_POST['menu_price'][$index]) && !empty(trim($_POST['menu_price'][$index]))) {
                    $price = trim($_POST['menu_price'][$index]);
                    $price = preg_replace('/[^0-9]/', '', $price);
                    
                    $menuImage = null;
                    if (isset($_FILES['menu_image']) && isset($_FILES['menu_image']['tmp_name'][$index]) && $_FILES['menu_image']['error'][$index] === UPLOAD_ERR_OK) {
                        $menuImage = $this->uploadMenuImage([
                            'name' => $_FILES['menu_image']['name'][$index],
                            'tmp_name' => $_FILES['menu_image']['tmp_name'][$index],
                            'type' => $_FILES['menu_image']['type'][$index],
                            'size' => $_FILES['menu_image']['size'][$index],
                            'error' => $_FILES['menu_image']['error'][$index]
                        ]);
                    } else {
                        $menuImage = $_POST['menu_existing_image'][$index] ?? null;
                    }
                    
                    $menus[] = [
                        'name' => $name,
                        'price' => (float) $price,
                        'image' => $menuImage
                    ];
                }
            }
        }
        $request->menus = $menus;

        try {
            // Get existing UMKM
            $existingUmkm = $this->umkmService->findById($id);
            if ($existingUmkm === null) {
                throw new ValidationException('UMKM tidak ditemukan');
            }

            // Handle featured image upload
            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                if ($existingUmkm->featuredImage) {
                    $this->deleteImage($existingUmkm->featuredImage, 'featured');
                }
                $request->featuredImage = $this->uploadImage($_FILES['featured_image'], 'featured');
            }

            // Handle owner photo upload
            if (isset($_FILES['owner_photo']) && $_FILES['owner_photo']['error'] === UPLOAD_ERR_OK) {
                if ($existingUmkm->ownerPhoto) {
                    $this->deleteImage($existingUmkm->ownerPhoto, 'owner');
                }
                $request->ownerPhoto = $this->uploadImage($_FILES['owner_photo'], 'owner');
            }

            $this->umkmService->update($request);
            $_SESSION['success'] = 'UMKM berhasil diperbarui';
            View::redirect('/admin/umkm');
        } catch (ValidationException $e) {
            $categories = $this->categoryRepository->findAll();
            $umkm = $this->umkmService->findById($id);

            View::renderAdmin('MSMEs/edit', [
                'title' => 'Edit UMKM',
                'current' => 'umkm',
                'user' => $this->sessionService->current(),
                'umkm' => $umkm,
                'categories' => $categories,
                'error' => $e->getMessage(),
                'old' => $_POST,
                'breadcrumbs' => [
                    [
                        'title' => 'UMKM Management',
                        'url' => '/admin/umkm'
                    ],
                    [
                        'title' => 'Edit UMKM',
                        'url' => null
                    ]
                ]
            ]);
        }
    }

    /**
     * Handle UMKM deletion
     */
    public function delete(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id === false || $id === null) {
            $_SESSION['error'] = 'ID UMKM tidak valid';
            View::redirect('/admin/umkm');
            return;
        }

        try {
            $umkm = $this->umkmService->findById($id);
            if ($umkm !== null) {
                if ($umkm->featuredImage) {
                    $this->deleteImage($umkm->featuredImage, 'featured');
                }
                if ($umkm->ownerPhoto) {
                    $this->deleteImage($umkm->ownerPhoto, 'owner');
                }
                foreach ($umkm->menus as $menu) {
                    if ($menu->image) {
                        $this->deleteImage($menu->image, 'menu');
                    }
                }
            }

            $this->umkmService->delete($id);
            $_SESSION['success'] = 'UMKM berhasil dihapus';
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        View::redirect('/admin/umkm');
    }

    /**
     * Handle image upload for UMKM
     */
    private function uploadImage(array $file, string $type): string
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
        $prefix = $type === 'featured' ? 'umkm' : ($type === 'owner' ? 'owner' : 'menu');
        $filename = $prefix . '_' . time() . '_' . uniqid() . '.' . $extension;
        
        $uploadDir = __DIR__ . '/../../../public/uploads/umkm/';
        $targetPath = $uploadDir . $filename;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        }

        return '';
    }

    /**
     * Handle menu image upload
     */
    private function uploadMenuImage(array $file): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            return null;
        }

        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            return null;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'menu_' . time() . '_' . uniqid() . '.' . $extension;
        
        $uploadDir = __DIR__ . '/../../../public/uploads/umkm/';
        $targetPath = $uploadDir . $filename;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        }

        return null;
    }

    /**
     * Delete image file
     */
    private function deleteImage(?string $filename, string $type): void
    {
        if (empty($filename)) {
            return;
        }

        $uploadDir = __DIR__ . '/../../../public/uploads/umkm/';
        $filePath = $uploadDir . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}