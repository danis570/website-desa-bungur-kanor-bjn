<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\ArticleCategory;
use PDO;

class ArticleCategoryRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(ArticleCategory $category): ArticleCategory
    {
        $statement = $this->pdo->prepare("
            INSERT INTO article_categories (
                name,
                slug
            )
            VALUES (?, ?)
        ");

        try {

            $statement->execute([
                $category->name,
                $category->slug
            ]);

            $category->id = (int) $this->pdo->lastInsertId();

            return $category;

        } finally {
            $statement->closeCursor();
        }
    }

    public function update(ArticleCategory $category): ArticleCategory
    {
        $statement = $this->pdo->prepare("
            UPDATE article_categories
            SET
                name = ?,
                slug = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
            AND deleted_at IS NULL
        ");

        $statement->execute([
            $category->name,
            $category->slug,
            $category->id
        ]);

        return $category;
    }

    public function findById(int $id): ?ArticleCategory
    {
        $statement = $this->pdo->prepare("
            SELECT *
            FROM article_categories
            WHERE id = ?
            AND deleted_at IS NULL
            LIMIT 1
        ");

        try {

            $statement->execute([$id]);

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return $this->mapToCategory($row);

        } finally {
            $statement->closeCursor();
        }
    }

    public function findBySlug(string $slug): ?ArticleCategory
    {
        $statement = $this->pdo->prepare("
            SELECT *
            FROM article_categories
            WHERE slug = ?
            AND deleted_at IS NULL
            LIMIT 1
        ");

        try {

            $statement->execute([$slug]);

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return $this->mapToCategory($row);

        } finally {
            $statement->closeCursor();
        }
    }

    public function findByName(string $name): ?ArticleCategory
    {
        $statement = $this->pdo->prepare("
            SELECT *
            FROM article_categories
            WHERE name = ?
            AND deleted_at IS NULL
            LIMIT 1
        ");

        try {

            $statement->execute([$name]);

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return $this->mapToCategory($row);

        } finally {
            $statement->closeCursor();
        }
    }

    public function findAll(): array
    {
        $statement = $this->pdo->prepare("
            SELECT *
            FROM article_categories
            WHERE deleted_at IS NULL
            ORDER BY name ASC
        ");

        try {

            $statement->execute();

            $categories = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $categories[] = $this->mapToCategory($row);
            }

            return $categories;

        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $statement = $this->pdo->prepare("
            UPDATE article_categories
            SET deleted_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");

        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->pdo->exec("DELETE FROM article_categories");
    }

    private function mapToCategory(array $row): ArticleCategory
    {
        $category = new ArticleCategory();

        $category->id = (int) $row['id'];
        $category->name = $row['name'];
        $category->slug = $row['slug'];
        $category->createdAt = $row['created_at'];
        $category->updatedAt = $row['updated_at'];
        $category->deletedAt = $row['deleted_at'];

        return $category;
    }
}
