<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Service;

use Kkn27Unirow\WebsiteDesaBungur\Domain\ArticleCategory;
use Kkn27Unirow\WebsiteDesaBungur\Exception\ValidationException;
use Kkn27Unirow\WebsiteDesaBungur\Model\ArticleCategoryCreateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Model\ArticleCategoryUpdateRequest;
use Kkn27Unirow\WebsiteDesaBungur\Repository\ArticleCategoryRepository;

class ArticleCategoryService
{
    private ArticleCategoryRepository $repository;

    public function __construct(ArticleCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(ArticleCategoryCreateRequest $request): ArticleCategory
    {
        $name = trim($request->name);
        $slug = trim($request->slug);

        if (empty($name)) {
            throw new ValidationException('Nama kategori wajib diisi');
        }

        if (empty($slug)) {
            throw new ValidationException('Slug kategori wajib diisi');
        }

        $existingCategory = $this->repository->findByName($name);
        if ($existingCategory !== null) {
            throw new ValidationException('Nama kategori sudah digunakan');
        }

        $existingCategory = $this->repository->findBySlug($slug);
        if ($existingCategory !== null) {
            throw new ValidationException('Slug kategori sudah digunakan');
        }

        $category = new ArticleCategory();
        $category->name = $name;
        $category->slug = $slug;

        return $this->repository->save($category);
    }

    public function update(ArticleCategoryUpdateRequest $request): ArticleCategory
    {
        $category = $this->repository->findById($request->id);
        if ($category === null) {
            throw new ValidationException('Kategori tidak ditemukan');
        }

        $name = trim($request->name);
        $slug = trim($request->slug);

        if (empty($name)) {
            throw new ValidationException('Nama kategori wajib diisi');
        }

        if (empty($slug)) {
            throw new ValidationException('Slug kategori wajib diisi');
        }

        if ($name !== $category->name) {
            $existingCategory = $this->repository->findByName($name);
            if ($existingCategory !== null && $existingCategory->id !== $category->id) {
                throw new ValidationException('Nama kategori sudah digunakan');
            }
        }

        if ($slug !== $category->slug) {
            $existingCategory = $this->repository->findBySlug($slug);
            if ($existingCategory !== null && $existingCategory->id !== $category->id) {
                throw new ValidationException('Slug kategori sudah digunakan');
            }
        }

        $category->name = $name;
        $category->slug = $slug;

        return $this->repository->update($category);
    }

    public function delete(int $id): void
    {
        $category = $this->repository->findById($id);
        if ($category === null) {
            throw new ValidationException('Kategori tidak ditemukan');
        }

        $this->repository->softDelete($id);
    }

    public function findById(int $id): ?ArticleCategory
    {
        return $this->repository->findById($id);
    }

    public function findBySlug(string $slug): ?ArticleCategory
    {
        return $this->repository->findBySlug($slug);
    }

    public function findByName(string $name): ?ArticleCategory
    {
        return $this->repository->findByName($name);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}