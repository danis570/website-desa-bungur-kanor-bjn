<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\User;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\CreatePhotoRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\UpdatePhotoRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\PhotoRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\PhotoService;
use Kkn27Unirow\WebsiteDesaBungur\Service\SessionService;

class PhotoController
{
    private PhotoService $photoService;
    private SessionService $sessionService;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $photoRepository = new PhotoRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $sessionRepository = new SessionRepository($pdo);

        $this->photoService = new PhotoService(
            $photoRepository,
            $userRepository
        );

        $this->sessionService = new SessionService(
            $sessionRepository,
            $userRepository
        );
    }

    /**
     * Display list of user's photos
     */
    public function index(): void
    {
        $user = $this->sessionService->current();

        // Get all photos for this user
        $photos = $this->photoService->findByUserId($user->id);

        // Ensure $photos is always an array
        if ($photos === null) {
            $photos = [];
        }

        View::renderUser('Photo/photo', [
            'title' => 'Kelola Foto',
            'current' => 'photo',
            'user' => $user,
            'photos' => $photos,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => '/user/dashboard'
                ],
                [
                    'title' => 'Kelola Foto',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Show create photo form
     */
    public function create(): void
    {
        $user = $this->sessionService->current();

        View::renderUser('Photo/create', [
            'title' => 'Tambah Foto',
            'current' => 'photo',
            'user' => $user,
            'breadcrumbs' => [
                [
                    'title' => 'Kelola Foto',
                    'url' => '/user/photo'
                ],
                [
                    'title' => 'Tambah Foto',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Handle create photo submission
     */
    public function postCreate(): void
    {
        $user = $this->sessionService->current();

        // DEBUG: Cek apakah ada file yang diupload
        error_log('=== PHOTO CREATE START ===');
        error_log('POST data: ' . print_r($_POST, true));
        error_log('FILES data: ' . print_r($_FILES, true));

        // Get form data
        $caption = trim($_POST['caption'] ?? '');
        $location = trim($_POST['location'] ?? '');

        // Handle image upload
        $image = $this->uploadImage($_FILES['image'] ?? null);

        error_log('Upload result: ' . ($image ?: 'EMPTY'));

        // Create request object
        $request = new CreatePhotoRequest(
            $caption,
            $location,
            $user->id
        );

        $request->image = $image;

        try {
            $this->photoService->create($request);
            $_SESSION['success'] = 'Foto berhasil ditambahkan';
            View::redirect('/user/photo');
        } catch (ValidationException $e) {
            $errors = json_decode($e->getMessage(), true);

            View::renderUser('Photo/create', [
                'title' => 'Tambah Foto',
                'current' => 'photo',
                'user' => $user,
                'errors' => $errors,
                'old' => [
                    'caption' => $caption,
                    'location' => $location
                ],
                'breadcrumbs' => [
                    [
                        'title' => 'Kelola Foto',
                        'url' => '/user/photo'
                    ],
                    [
                        'title' => 'Tambah Foto',
                        'url' => null
                    ]
                ]
            ]);
        }
    }
    /**
     * Show edit photo form
     */
    public function edit(int $id): void
    {
        $user = $this->sessionService->current();
        $photo = $this->photoService->findById($id);

        // Check if photo exists and belongs to current user
        if ($photo === null || $photo->photo->userId !== $user->id) {
            $_SESSION['error'] = 'Foto tidak ditemukan atau Anda tidak memiliki akses';
            View::redirect('/user/photo');
            return;
        }

        View::renderUser('Photo/edit', [
            'title' => 'Edit Foto',
            'current' => 'photo',
            'user' => $user,
            'photo' => $photo->photo,
            'breadcrumbs' => [
                [
                    'title' => 'Kelola Foto',
                    'url' => '/user/photo'
                ],
                [
                    'title' => 'Edit Foto',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Handle edit photo submission
     */
    public function postEdit(int $id): void
    {
        $user = $this->sessionService->current();

        // Check if photo exists and belongs to current user
        $photo = $this->photoService->findById($id);
        if ($photo === null || $photo->photo->userId !== $user->id) {
            $_SESSION['error'] = 'Foto tidak ditemukan atau Anda tidak memiliki akses';
            View::redirect('/user/photo');
            return;
        }

        // Get form data
        $caption = trim($_POST['caption'] ?? '');
        $location = trim($_POST['location'] ?? '');

        // Handle image upload
        $oldImage = $photo->photo->image;
        $newImage = $this->uploadImage($_FILES['image'] ?? null);

        // Create update request
        $request = new UpdatePhotoRequest(
            $id,
            $caption,
            $location
        );

        // Jika upload gambar baru berhasil
        if (!empty($newImage)) {
            // Hapus gambar lama
            if (!empty($oldImage)) {
                $oldImagePath = __DIR__ . '/../../../public/uploads/photos/' . $oldImage;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            // Set image baru
            $request->image = $newImage;
        } else {
            // Tidak upload gambar baru, gunakan gambar lama
            $request->image = $oldImage;
        }

        try {
            $this->photoService->update($request);
            $_SESSION['success'] = 'Foto berhasil diperbarui';
            View::redirect('/user/photo');
        } catch (ValidationException $e) {
            $errors = json_decode($e->getMessage(), true);

            View::renderUser('Photo/edit', [
                'title' => 'Edit Foto',
                'current' => 'photo',
                'user' => $user,
                'photo' => $photo->photo,
                'errors' => $errors,
                'old' => [
                    'caption' => $caption,
                    'location' => $location
                ],
                'breadcrumbs' => [
                    [
                        'title' => 'Kelola Foto',
                        'url' => '/user/photo'
                    ],
                    [
                        'title' => 'Edit Foto',
                        'url' => null
                    ]
                ]
            ]);
        }
    }

    /**
     * Handle photo deletion
     */
    public function delete(int $id): void
    {
        $user = $this->sessionService->current();

        // Check if photo exists and belongs to current user
        $photo = $this->photoService->findById($id);
        if ($photo === null || $photo->photo->userId !== $user->id) {
            $_SESSION['error'] = 'Foto tidak ditemukan atau Anda tidak memiliki akses';
            View::redirect('/user/photo');
            return;
        }

        try {
            // Hapus file fisik jika ada
            $imageFile = $photo->photo->image ?? '';
            if (!empty($imageFile)) {
                $imagePath = __DIR__ . '/../../../public/uploads/photos/' . $imageFile;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Hapus foto dari database
            $this->photoService->delete($id);
            $_SESSION['success'] = 'Foto berhasil dihapus';
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        View::redirect('/user/photo');
    }

    /**
     * Handle image upload
     */
    private function uploadImage(?array $file): string
    {
        // No file uploaded
        if ($file === null || $file['error'] === UPLOAD_ERR_NO_FILE) {
            error_log('PHOTO UPLOAD: No file uploaded');
            return '';
        }

        // Upload error
        if ($file['error'] !== UPLOAD_ERR_OK) {
            error_log('PHOTO UPLOAD: Upload error code - ' . $file['error']);
            return '';
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            error_log('PHOTO UPLOAD: Invalid file type - ' . $file['type']);
            return '';
        }

        // Validate file size (max 2MB)
        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            error_log('PHOTO UPLOAD: File too large - ' . $file['size'] . ' bytes');
            return '';
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'foto_desa_' . time() . '_' . uniqid() . '.' . $extension;

        // PERBAIKI PATH - Gunakan path dari root project
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/';
        $targetPath = $uploadDir . $filename;

        error_log('PHOTO UPLOAD: Target path - ' . $targetPath);

        // Create directory if not exists
        if (!is_dir($uploadDir)) {
            if (mkdir($uploadDir, 0755, true)) {
                error_log('PHOTO UPLOAD: Directory created - ' . $uploadDir);
            } else {
                error_log('PHOTO UPLOAD: Failed to create directory - ' . $uploadDir);
                return '';
            }
        }

        // Cek apakah folder bisa ditulis
        if (!is_writable($uploadDir)) {
            error_log('PHOTO UPLOAD: Directory not writable - ' . $uploadDir);
            return '';
        }

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            error_log('PHOTO UPLOAD: File uploaded successfully - ' . $filename);
            return $filename;
        }

        error_log('PHOTO UPLOAD: Failed to move uploaded file from ' . $file['tmp_name'] . ' to ' . $targetPath);
        return '';
    }
}