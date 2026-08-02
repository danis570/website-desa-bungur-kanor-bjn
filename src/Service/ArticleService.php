<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Kkn27Unirow\WebsiteDesaBungur\Domain\Article;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\ArticleCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\ArticleUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleCategoryRepository;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleRepository;

class ArticleService
{
    private ArticleRepository $articleRepository;
    private ArticleCategoryRepository $categoryRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        ArticleCategoryRepository $categoryRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(ArticleCreateRequest $request): Article
    {
        $this->validateCreate($request);

        $slug = $this->generateSlug($request->title);
        $this->ensureSlugIsUnique($slug);

        $excerpt = $request->excerpt ?? $this->generateExcerpt($request->content);

        $article = new Article();
        $article->title = trim($request->title);
        $article->slug = $slug;
        $article->userId = $request->userId;
        $article->categoryId = $request->categoryId;
        $article->excerpt = $excerpt;
        $article->status = $request->status;
        $article->publishedAt = $request->status === 'published' ? date('Y-m-d H:i:s') : null;
        $article->image = $request->image ?? null;
        $article->imageAlt = $request->imageAlt ?? null; // <-- TAMBAHKAN INI
        $article->content = trim($request->content);

        return $this->articleRepository->save($article);
    }

    public function update(ArticleUpdateRequest $request): Article
    {
        $this->validateUpdate($request);

        $article = $this->articleRepository->findById($request->id);
        if ($article === null) {
            throw new ValidationException('Article not found');
        }

        $slug = $this->generateSlug($request->title);

        if ($slug !== $article->slug) {
            $this->ensureSlugIsUnique($slug, $request->id);
        }

        $excerpt = $request->excerpt ?? $this->generateExcerpt($request->content);

        $article->title = trim($request->title);
        $article->slug = $slug;
        $article->categoryId = $request->categoryId;
        $article->excerpt = $excerpt;
        $article->status = $request->status;
        
        if ($request->status === 'published') {
            // Jika belum pernah dipublish, isi waktu publish
            if ($article->publishedAt === null) {
                $article->publishedAt = date('Y-m-d H:i:s');
            }
        } else {
            // Jika status draft
            $article->publishedAt = null;
        }
        
        $article->image = $request->image ?? $article->image;
        $article->imageAlt = $request->imageAlt ?? $article->imageAlt; // <-- TAMBAHKAN INI
        $article->content = trim($request->content);

        return $this->articleRepository->update($article);
    }

    public function delete(int $id): void
    {
        $article = $this->articleRepository->findById($id);
        if ($article === null) {
            throw new ValidationException('Article not found');
        }

        $this->articleRepository->softDelete($id);
    }

    public function findAll(): array
    {
        return $this->articleRepository->findAll();
    }

    public function findPublished(): array
    {
        return $this->articleRepository->findPublished();
    }

    public function findByUserId(int $userId): array
    {
        return $this->articleRepository->findByUserId($userId);
    }

    public function findById(int $id): ?Article
    {
        return $this->articleRepository->findById($id);
    }

    public function findBySlug(string $slug): ?Article
    {
        return $this->articleRepository->findBySlug($slug);
    }

    private function validateCreate(ArticleCreateRequest $request): void
    {
        $errors = [];

        if (empty(trim($request->title))) {
            $errors['title'] = 'Title is required';
        }

        if (empty($request->categoryId) || $request->categoryId <= 0) {
            $errors['categoryId'] = 'Category is required';
        } else {
            $category = $this->categoryRepository->findById($request->categoryId);
            if ($category === null) {
                $errors['categoryId'] = 'Category not found';
            }
        }

        if (empty(trim($request->content))) {
            $errors['content'] = 'Content is required';
        }

        if (!empty($request->status) && !in_array($request->status, ['draft', 'published'], true)) {
            $errors['status'] = 'Status must be draft or published';
        }

        if (!empty($errors)) {
            throw new ValidationException(json_encode($errors));
        }
    }

    private function validateUpdate(ArticleUpdateRequest $request): void
    {
        $errors = [];

        if (empty(trim($request->title))) {
            $errors['title'] = 'Title is required';
        }

        if (empty($request->categoryId) || $request->categoryId <= 0) {
            $errors['categoryId'] = 'Category is required';
        } else {
            $category = $this->categoryRepository->findById($request->categoryId);
            if ($category === null) {
                $errors['categoryId'] = 'Category not found';
            }
        }

        if (empty(trim($request->content))) {
            $errors['content'] = 'Content is required';
        }

        if (!empty($request->status) && !in_array($request->status, ['draft', 'published'], true)) {
            $errors['status'] = 'Status must be draft or published';
        }

        if (!empty($errors)) {
            throw new ValidationException(json_encode($errors));
        }
    }

    private function generateSlug(string $title): string
    {
        $slug = trim($title);
        $slug = strtolower($slug);
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        return $slug;
    }

    private function generateExcerpt(string $content): string
    {
        // Remove HTML tags
        $excerpt = strip_tags($content);

        // Decode HTML entities
        $excerpt = html_entity_decode($excerpt, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Remove extra whitespace and normalize spaces
        $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));

        // Trim to 200 characters
        if (strlen($excerpt) > 200) {
            $excerpt = substr($excerpt, 0, 200);
            $lastSpace = strrpos($excerpt, ' ');
            if ($lastSpace !== false) {
                $excerpt = substr($excerpt, 0, $lastSpace);
            }
            $excerpt .= '...';
        }

        return $excerpt;
    }

    private function ensureSlugIsUnique(string $slug, ?int $excludeId = null): void
    {
        $existingArticle = $this->articleRepository->findBySlug($slug);

        if ($existingArticle !== null) {
            if ($excludeId === null || $existingArticle->id !== $excludeId) {
                throw new ValidationException('Slug already used by another article');
            }
        }
    }
}