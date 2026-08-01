<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\Photo;
use PDO;

class PhotoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Photo $photo): Photo
    {
        $statement = $this->pdo->prepare("
        INSERT INTO photos (
            caption,
            location,
            user_id,
            image  -- <-- Tambahkan kolom image
        )
        VALUES (?, ?, ?, ?)
    ");

        try {
            $statement->execute([
                $photo->caption,
                $photo->location,
                $photo->userId,
                $photo->image ?? null
            ]);

            $photo->id = (int) $this->pdo->lastInsertId();

            return $photo;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(Photo $photo): Photo
    {
        $statement = $this->pdo->prepare("
        UPDATE photos
        SET
            caption = ?,
            location = ?,
            image = ?,  -- <-- Tambahkan image
            updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
        AND deleted_at IS NULL
    ");

        try {
            $statement->execute([
                $photo->caption,
                $photo->location,
                $photo->image ?? null,
                $photo->id
            ]);

            return $photo;
        } finally {
            $statement->closeCursor();
        }
    }


    public function findById(int $id): ?Photo
    {
        $statement = $this->pdo->prepare("
            SELECT
                p.*,
                u.name AS user_name
            FROM photos p
            JOIN users u
                ON u.id = p.user_id
            WHERE p.id = ?
            AND p.deleted_at IS NULL
            LIMIT 1
        ");

        try {

            $statement->execute([$id]);

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return $this->mapToPhoto($row);

        } finally {
            $statement->closeCursor();
        }
    }

    public function findAll(): array
    {
        $statement = $this->pdo->prepare("
            SELECT
                p.*,
                u.name AS user_name
            FROM photos p
            JOIN users u
                ON u.id = p.user_id
            WHERE p.deleted_at IS NULL
            ORDER BY p.created_at DESC, p.id DESC
        ");

        try {

            $statement->execute();

            $photos = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $photos[] = $this->mapToPhoto($row);
            }

            return $photos;

        } finally {
            $statement->closeCursor();
        }
    }

    public function findByUserId(int $userId): array
    {
        $statement = $this->pdo->prepare("
            SELECT
                p.*,
                u.name AS user_name
            FROM photos p
            JOIN users u
                ON u.id = p.user_id
            WHERE
                p.user_id = ?
                AND p.deleted_at IS NULL
            ORDER BY p.created_at DESC
        ");

        try {

            $statement->execute([$userId]);

            $photos = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $photos[] = $this->mapToPhoto($row);
            }

            return $photos;

        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $statement = $this->pdo->prepare("
            UPDATE photos
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
        $this->pdo->exec("DELETE FROM photos");
    }


    private function mapToPhoto(array $row): Photo
    {
        $photo = new Photo();

        $photo->id = (int) $row['id'];
        $photo->caption = $row['caption'] ?? '';
        $photo->location = $row['location'] ?? '';
        $photo->image = $row['image'] ?? null; // <-- Tambahkan ini
        $photo->userId = (int) $row['user_id'];
        $photo->userName = $row['user_name'] ?? '';
        $photo->createdAt = $row['created_at'] ?? null;
        $photo->updatedAt = $row['updated_at'] ?? null;
        $photo->deletedAt = $row['deleted_at'] ?? null;

        return $photo;
    }
}