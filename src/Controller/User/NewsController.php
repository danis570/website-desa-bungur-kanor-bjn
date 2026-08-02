<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Controller\User;

use Kkn27Unirow\WebsiteDesaBungur\App\View;
use Kkn27Unirow\WebsiteDesaBungur\Config\Database;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\ArticleCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\ArticleUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\SessionRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\UserRepository;
use Kkn27Unirow\WebsiteDesaBungur\Service\ArticleCategoryService;
use Kkn27Unirow\WebsiteDesaBungur\Service\ArticleService;
use Kkn27Unirow\WebsiteDesaBungur\Service\SessionService;

class NewsController
{
    private ArticleService $articleService;
    private ArticleCategoryService $categoryService;
    private SessionService $sessionService;

    public function __construct()
    {
        $pdo = Database::getConnection();

        $articleRepository = new ArticleRepository($pdo);
        $categoryRepository = new ArticleCategoryRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $sessionRepository = new SessionRepository($pdo);

        $this->articleService = new ArticleService(
            $articleRepository,
            $categoryRepository
        );

        $this->categoryService = new ArticleCategoryService($categoryRepository);

        $this->sessionService = new SessionService(
            $sessionRepository,
            $userRepository
        );
    }

    /**
     * Display list of user's articles
     */
    public function index(): void
    {
        $user = $this->sessionService->current();

        // Get all articles for this user
        $articles = $this->articleService->findByUserId($user->id);

        // Ensure $articles is always an array
        if ($articles === null) {
            $articles = [];
        }

        View::renderUser('News/news', [
            'title' => 'Kelola Berita',
            'current' => 'news',
            'user' => $user,
            'articles' => $articles,
            'breadcrumbs' => [
                [
                    'title' => 'Dashboard',
                    'url' => '/user/dashboard'
                ],
                [
                    'title' => 'Kelola Berita',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Show create article form
     */
    public function create(): void
    {
        $user = $this->sessionService->current();
        $categories = $this->categoryService->findAll();

        View::renderUser('News/create', [
            'title' => 'Tambah Berita',
            'current' => 'news',
            'user' => $user,
            'categories' => $categories,
            'breadcrumbs' => [
                [
                    'title' => 'Kelola Berita',
                    'url' => '/user/news'
                ],
                [
                    'title' => 'Tambah Berita',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Handle create article submission
     */
    public function postCreate(): void
    {
        $user = $this->sessionService->current();

        // Get form data
        $title = trim($_POST['title'] ?? '');
        $categoryId = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;
        $content = trim($_POST['content'] ?? '');
        $status = $_POST['status'] ?? 'draft';
        $excerpt = !empty($_POST['excerpt']) ? trim($_POST['excerpt']) : null;
        $imageAlt = !empty($_POST['image_alt']) ? trim($_POST['image_alt']) : null; // <-- TAMBAHKAN INI

        if ($categoryId <= 0) {
            $_SESSION['error'] = 'Kategori wajib dipilih';
            View::redirect('/user/news/add');
            return;
        }

        // Handle image upload
        $image = $this->uploadImage($_FILES['image'] ?? null);

        // Create request object
        $request = new ArticleCreateRequest();
        $request->title = $title;
        $request->userId = $user->id;
        $request->categoryId = $categoryId;
        $request->content = $content;
        $request->status = $status;
        $request->excerpt = $excerpt;
        $request->image = $image;
        $request->imageAlt = $imageAlt; // <-- TAMBAHKAN INI

        try {
            $this->articleService->create($request);
            $_SESSION['success'] = 'Berita berhasil ditambahkan';
            View::redirect('/user/news');
        } catch (ValidationException $e) {
            $categories = $this->categoryService->findAll();
            $errors = json_decode($e->getMessage(), true);

            View::renderUser('News/create', [
                'title' => 'Tambah Berita',
                'current' => 'news',
                'user' => $user,
                'categories' => $categories,
                'errors' => $errors,
                'old' => [
                    'title' => $title,
                    'category_id' => $categoryId,
                    'content' => $content,
                    'status' => $status,
                    'excerpt' => $excerpt,
                    'image_alt' => $imageAlt // <-- TAMBAHKAN INI
                ],
                'breadcrumbs' => [
                    [
                        'title' => 'Kelola Berita',
                        'url' => '/user/news'
                    ],
                    [
                        'title' => 'Tambah Berita',
                        'url' => null
                    ]
                ]
            ]);
        }
    }

    /**
     * Show edit article form
     */
    public function edit(int $id): void
    {
        $user = $this->sessionService->current();
        $article = $this->articleService->findById($id);

        // Check if article exists and belongs to current user
        if ($article === null || $article->userId !== $user->id) {
            $_SESSION['error'] = 'Berita tidak ditemukan atau Anda tidak memiliki akses';
            View::redirect('/user/news');
            return;
        }

        $categories = $this->categoryService->findAll();

        View::renderUser('News/edit', [
            'title' => 'Edit Berita',
            'current' => 'news',
            'user' => $user,
            'article' => $article,
            'categories' => $categories,
            'breadcrumbs' => [
                [
                    'title' => 'Kelola Berita',
                    'url' => '/user/news'
                ],
                [
                    'title' => 'Edit Berita',
                    'url' => null
                ]
            ]
        ]);
    }

    /**
     * Handle edit article submission
     */
    public function postEdit(int $id): void
    {
        $user = $this->sessionService->current();

        // Check if article exists and belongs to current user
        $article = $this->articleService->findById($id);
        if ($article === null || $article->userId !== $user->id) {
            $_SESSION['error'] = 'Berita tidak ditemukan atau Anda tidak memiliki akses';
            View::redirect('/user/news');
            return;
        }

        // Get form data
        $title = trim($_POST['title'] ?? '');
        $categoryId = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;
        $content = trim($_POST['content'] ?? '');
        $status = $_POST['status'] ?? 'draft';
        $excerpt = !empty($_POST['excerpt']) ? trim($_POST['excerpt']) : null;
        $imageAlt = !empty($_POST['image_alt']) ? trim($_POST['image_alt']) : null; // <-- TAMBAHKAN INI

        // Handle image upload
        $oldImage = $article->image;
        $image = $this->uploadImage($_FILES['image'] ?? null);

        // Jika upload gambar baru berhasil
        if ($image !== 'default-news.jpg') {

            // Hapus gambar lama (kecuali default)
            if (!empty($oldImage) && $oldImage !== 'default-news.jpg') {

                $oldImagePath = __DIR__ . '/../../../public/uploads/articles/' . $oldImage;

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

        } else {
            // Tidak upload gambar baru, gunakan gambar lama
            $image = $oldImage ?? 'default-news.jpg';
        }

        // Create update request
        $request = new ArticleUpdateRequest();
        $request->id = $id;
        $request->title = $title;
        $request->categoryId = $categoryId;
        $request->content = $content;
        $request->status = $status;
        $request->excerpt = $excerpt;
        $request->image = $image;
        $request->imageAlt = $imageAlt ?? $article->imageAlt; // <-- TAMBAHKAN INI

        try {
            $this->articleService->update($request);
            $_SESSION['success'] = 'Berita berhasil diperbarui';
            View::redirect('/user/news');
        } catch (ValidationException $e) {
            $categories = $this->categoryService->findAll();
            $errors = json_decode($e->getMessage(), true);

            View::renderUser('News/edit', [
                'title' => 'Edit Berita',
                'current' => 'news',
                'user' => $user,
                'article' => $article,
                'categories' => $categories,
                'errors' => $errors,
                'old' => [
                    'title' => $title,
                    'category_id' => $categoryId,
                    'content' => $content,
                    'status' => $status,
                    'excerpt' => $excerpt,
                    'image_alt' => $imageAlt // <-- TAMBAHKAN INI
                ],
                'breadcrumbs' => [
                    [
                        'title' => 'Kelola Berita',
                        'url' => '/user/news'
                    ],
                    [
                        'title' => 'Edit Berita',
                        'url' => null
                    ]
                ]
            ]);
        }
    }

    /**
     * Handle article deletion
     */
    public function delete(int $id): void
    {
        $user = $this->sessionService->current();

        // Check if article exists and belongs to current user
        $article = $this->articleService->findById($id);
        if ($article === null || $article->userId !== $user->id) {
            $_SESSION['error'] = 'Berita tidak ditemukan atau Anda tidak memiliki akses';
            View::redirect('/user/news');
            return;
        }

        try {
            if (!empty($article->image)) {
                $imagePath = __DIR__ . '/../../../public/uploads/articles/' . $article->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Hapus berita dari database
            $this->articleService->delete($id);
            $_SESSION['success'] = 'Berita berhasil dihapus';
        } catch (ValidationException $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        View::redirect('/user/news');
    }

    /**
     * Handle image upload
     */
    private function uploadImage(?array $file): string
    {
        // No file uploaded
        if ($file === null || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return 'default-news.jpg';
        }

        // Upload error
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return 'default-news.jpg';
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return 'default-news.jpg';
        }

        // Validate file size (max 2MB)
        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            return 'default-news.jpg';
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'berita_desa_' . time() . '_' . uniqid() . '.' . $extension;
        $targetPath = __DIR__ . '/../../../public/uploads/articles/' . $filename;

        // Create directory if not exists
        $uploadDir = dirname($targetPath);
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $filename;
        }

        return 'default-news.jpg';
    }
}