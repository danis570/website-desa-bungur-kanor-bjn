<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\Article;
use PDO;

class ArticleRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Article $article): Article
    {
        $statement = $this->pdo->prepare("
        INSERT INTO articles (
            title,
            slug,
            user_id,
            category_id,
            excerpt,
            status,
            published_at,
            image,
            image_alt,
            content
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

        try {
            $statement->execute([
                $article->title,
                $article->slug,
                $article->userId,
                $article->categoryId,
                $article->excerpt,
                $article->status,
                $article->publishedAt,
                $article->image,
                $article->imageAlt, // <-- TAMBAHKAN INI
                $article->content
            ]);

            $article->id = (int) $this->pdo->lastInsertId();

            return $article;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(Article $article): Article
    {
        $statement = $this->pdo->prepare("
        UPDATE articles
        SET
            title = ?,
            slug = ?,
            category_id = ?,
            excerpt = ?,
            status = ?,
            published_at = ?,
            image = ?,
            image_alt = ?,
            content = ?,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
        AND deleted_at IS NULL
    ");

        $statement->execute([
            $article->title,
            $article->slug,
            $article->categoryId,
            $article->excerpt,
            $article->status,
            $article->publishedAt,
            $article->image,
            $article->imageAlt, // <-- TAMBAHKAN INI
            $article->content,
            $article->id
        ]);

        return $article;
    }

    public function findById(int $id): ?Article
    {
        $statement = $this->pdo->prepare("
            SELECT
                a.*,
                u.name AS author_name,
                c.name AS category_name
            FROM articles a
            JOIN users u
                ON u.id = a.user_id
            JOIN article_categories c
                ON c.id = a.category_id
            WHERE a.id = ?
            AND a.deleted_at IS NULL
            LIMIT 1
        ");

        try {

            $statement->execute([$id]);

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return $this->mapToArticle($row);

        } finally {
            $statement->closeCursor();
        }
    }

    public function findBySlug(string $slug): ?Article
    {
        $statement = $this->pdo->prepare("
        SELECT
            a.*,
            u.name AS author_name,
            u.position AS author_position,
            u.avatar AS author_avatar, 
            c.name AS category_name
        FROM articles a
        JOIN users u ON u.id = a.user_id
        LEFT JOIN article_categories c ON c.id = a.category_id
        WHERE a.slug = ?
        AND a.deleted_at IS NULL
        LIMIT 1
    ");

        try {
            $statement->execute([$slug]);
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return $this->mapToArticle($row);
        } finally {
            $statement->closeCursor();
        }
    }

    public function findAll(): array
    {
        $statement = $this->pdo->prepare("
           SELECT
                a.*,
                u.name AS author_name,
                c.name AS category_name
            FROM articles a
            JOIN users u
                ON u.id = a.user_id
            JOIN article_categories c
                ON c.id = a.category_id
            WHERE a.deleted_at IS NULL
            ORDER BY a.created_at DESC, a.id DESC
        ");

        try {

            $statement->execute();

            $articles = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $articles[] = $this->mapToArticle($row);
            }

            return $articles;

        } finally {
            $statement->closeCursor();
        }
    }

    public function findPublished(): array
    {
        $statement = $this->pdo->prepare("
            SELECT
                a.*,
                u.name AS author_name,
                c.name AS category_name
            FROM articles a
            JOIN users u
                ON u.id = a.user_id
            JOIN article_categories c
                ON c.id = a.category_id
            WHERE
                a.deleted_at IS NULL
                AND a.status = 'published'
            ORDER BY a.published_at DESC
        ");

        try {

            $statement->execute();

            $articles = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $articles[] = $this->mapToArticle($row);
            }

            return $articles;

        } finally {
            $statement->closeCursor();
        }
    }

    public function findByUserId(int $userId): array
    {
        $statement = $this->pdo->prepare("
            SELECT
                a.*,
                u.name AS author_name,
                c.name AS category_name
            FROM articles a
            JOIN users u
                ON u.id = a.user_id
            JOIN article_categories c
                ON c.id = a.category_id
            WHERE
                a.deleted_at IS NULL
                AND a.user_id = ?
            ORDER BY a.created_at DESC
        ");

        try {

            $statement->execute([$userId]);

            $articles = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $articles[] = $this->mapToArticle($row);
            }

            return $articles;

        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $statement = $this->pdo->prepare("
            UPDATE articles
            SET deleted_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");

        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->pdo->exec("DELETE FROM articles");
    }

   private function mapToArticle(array $row): Article
{
    $article = new Article();

    $article->id = (int) $row['id'];
    $article->title = $row['title'];
    $article->slug = $row['slug'];
    $article->userId = (int) $row['user_id'];
    $article->categoryId = (int) $row['category_id'];
    $article->authorName = $row['author_name'];
    $article->authorPosition = $row['author_position'] ?? null;
    $article->authorAvatar = $row['author_avatar'] ?? null; // <-- TAMBAHKAN INI
    $article->categoryName = $row['category_name'];
    $article->excerpt = $row['excerpt'];
    $article->status = $row['status'];
    $article->publishedAt = $row['published_at'];
    $article->image = $row['image'];
    $article->imageAlt = $row['image_alt'] ?? null;
    $article->content = $row['content'];
    $article->createdAt = $row['created_at'];
    $article->updatedAt = $row['updated_at'];
    $article->deletedAt = $row['deleted_at'];

    return $article;
}
}