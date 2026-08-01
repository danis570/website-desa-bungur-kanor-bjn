<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\UmkmCategory;
use PDO;

class UmkmCategoryRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $statement = $this->pdo->prepare("
        SELECT * FROM umkm_categories 
        WHERE deleted_at IS NULL 
        ORDER BY name ASC
    ");

        try {
            $statement->execute();
            $categories = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $category = new UmkmCategory();
                $category->id = (int) $row['id'];
                $category->name = $row['name'];
                $category->slug = $row['slug'];
                $category->createdAt = $row['created_at'] ?? null;
                $category->updatedAt = $row['updated_at'] ?? null;
                $category->deletedAt = $row['deleted_at'] ?? null;
                $categories[] = $category;
            }

            return $categories;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(int $id): ?UmkmCategory
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM umkm_categories 
            WHERE id = ? AND deleted_at IS NULL
            LIMIT 1
        ");

        try {
            $statement->execute([$id]);
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            $category = new UmkmCategory();
            $category->id = (int) $row['id'];
            $category->name = $row['name'];
            $category->slug = $row['slug'];
            $category->createdAt = $row['created_at'] ?? null;
            $category->updatedAt = $row['updated_at'] ?? null;
            $category->deletedAt = $row['deleted_at'] ?? null;

            return $category;
        } finally {
            $statement->closeCursor();
        }
    }
}