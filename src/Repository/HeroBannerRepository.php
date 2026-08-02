<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\HeroBanner;
use PDO;

class HeroBannerRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(HeroBanner $banner): HeroBanner
    {
        $statement = $this->pdo->prepare("
            INSERT INTO hero_banners (title, description, image)
            VALUES (?, ?, ?)
        ");

        try {
            $statement->execute([
                $banner->title,
                $banner->description ?? null,
                $banner->image
            ]);

            $banner->id = (int) $this->pdo->lastInsertId();

            return $banner;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(HeroBanner $banner): HeroBanner
    {
        $statement = $this->pdo->prepare("
            UPDATE hero_banners
            SET
                title = ?,
                description = ?,
                image = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
            AND deleted_at IS NULL
        ");

        try {
            $statement->execute([
                $banner->title,
                $banner->description ?? null,
                $banner->image,
                $banner->id
            ]);

            $banner->updatedAt = date('Y-m-d H:i:s');

            return $banner;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(int $id): ?HeroBanner
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM hero_banners
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

            return $this->mapToDomain($row);
        } finally {
            $statement->closeCursor();
        }
    }

    public function findAll(): array
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM hero_banners
            WHERE deleted_at IS NULL
            ORDER BY created_at DESC, id DESC
        ");

        try {
            $statement->execute();
            $banners = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $banners[] = $this->mapToDomain($row);
            }

            return $banners;
        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $statement = $this->pdo->prepare("
            UPDATE hero_banners
            SET deleted_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");

        try {
            $statement->execute([$id]);
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $this->pdo->exec("DELETE FROM hero_banners");
    }

    private function mapToDomain(array $row): HeroBanner
    {
        $banner = new HeroBanner();

        $banner->id = (int) $row['id'];
        $banner->title = $row['title'];
        $banner->description = $row['description'] ?? null;
        $banner->image = $row['image'];
        $banner->createdAt = $row['created_at'] ?? null;
        $banner->updatedAt = $row['updated_at'] ?? null;
        $banner->deletedAt = $row['deleted_at'] ?? null;

        return $banner;
    }
}