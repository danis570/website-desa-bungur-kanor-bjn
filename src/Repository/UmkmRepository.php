<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\Umkm;
use PDO;

class UmkmRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(Umkm $umkm): Umkm
    {
        $statement = $this->pdo->prepare("
            INSERT INTO umkms (
                category_id,
                name,
                owner,
                owner_photo,
                featured_image,
                description,
                address,
                business_hours,
                whatsapp,
                maps_embed_url
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        try {
            $statement->execute([
                $umkm->categoryId,
                $umkm->name,
                $umkm->owner,
                $umkm->ownerPhoto ?? null,
                $umkm->featuredImage ?? null,
                $umkm->description ?? null,
                $umkm->address ?? null,
                $umkm->businessHours ?? null,
                $umkm->whatsapp ?? null,
                $umkm->mapsEmbedUrl ?? null
            ]);

            $umkm->id = (int) $this->pdo->lastInsertId();

            return $umkm;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(Umkm $umkm): Umkm
    {
        $statement = $this->pdo->prepare("
        UPDATE umkms
        SET
            category_id = ?,
            name = ?,
            owner = ?,
            owner_photo = ?,
            featured_image = ?,
            description = ?,
            address = ?,
            business_hours = ?,
            whatsapp = ?,
            maps_embed_url = ?,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
        AND deleted_at IS NULL
    ");

        try {
            $statement->execute([
                $umkm->categoryId,
                $umkm->name,
                $umkm->owner,
                $umkm->ownerPhoto ?? null,
                $umkm->featuredImage ?? null,
                $umkm->description ?? null,
                $umkm->address ?? null,
                $umkm->businessHours ?? null,
                $umkm->whatsapp ?? null,
                $umkm->mapsEmbedUrl ?? null,
                $umkm->id
            ]);

            // Ambil data terbaru setelah update
            $updatedUmkm = $this->findById($umkm->id);
            if ($updatedUmkm !== null) {
                return $updatedUmkm;
            }

            return $umkm;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(int $id): ?Umkm
    {
        $statement = $this->pdo->prepare("
            SELECT 
                u.*,
                c.name AS category_name
            FROM umkms u
            LEFT JOIN umkm_categories c ON c.id = u.category_id
            WHERE u.id = ?
            AND u.deleted_at IS NULL
            LIMIT 1
        ");

        try {
            $statement->execute([$id]);
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return $this->mapToUmkm($row);
        } finally {
            $statement->closeCursor();
        }
    }

    public function findAll(): array
    {
        $statement = $this->pdo->prepare("
            SELECT 
                u.*,
                c.name AS category_name
            FROM umkms u
            LEFT JOIN umkm_categories c ON c.id = u.category_id
            WHERE u.deleted_at IS NULL
            ORDER BY u.created_at DESC, u.id DESC
        ");

        try {
            $statement->execute();
            $umkms = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $umkms[] = $this->mapToUmkm($row);
            }

            return $umkms;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findByCategoryId(int $categoryId): array
    {
        $statement = $this->pdo->prepare("
            SELECT 
                u.*,
                c.name AS category_name
            FROM umkms u
            LEFT JOIN umkm_categories c ON c.id = u.category_id
            WHERE u.category_id = ?
            AND u.deleted_at IS NULL
            ORDER BY u.created_at DESC
        ");

        try {
            $statement->execute([$categoryId]);
            $umkms = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $umkms[] = $this->mapToUmkm($row);
            }

            return $umkms;
        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $statement = $this->pdo->prepare("
            UPDATE umkms
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
        $this->pdo->exec("DELETE FROM umkms");
    }

    private function mapToUmkm(array $row): Umkm
    {
        $umkm = new Umkm();

        $umkm->id = (int) $row['id'];
        $umkm->categoryId = (int) $row['category_id'];
        $umkm->name = $row['name'];
        $umkm->owner = $row['owner'];
        $umkm->ownerPhoto = $row['owner_photo'] ?? null;
        $umkm->featuredImage = $row['featured_image'] ?? null;
        $umkm->description = $row['description'] ?? null;
        $umkm->address = $row['address'] ?? null;
        $umkm->businessHours = $row['business_hours'] ?? null;
        $umkm->whatsapp = $row['whatsapp'] ?? null;
        $umkm->mapsEmbedUrl = $row['maps_embed_url'] ?? null;
        $umkm->categoryName = $row['category_name'] ?? null;
        $umkm->createdAt = $row['created_at'] ?? null;
        $umkm->updatedAt = $row['updated_at'] ?? null;
        $umkm->deletedAt = $row['deleted_at'] ?? null;

        return $umkm;
    }
}