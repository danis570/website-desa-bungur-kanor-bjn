<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageOfficial;
use PDO;

class VillageOfficialRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(VillageOfficial $official): VillageOfficial
    {
        $statement = $this->pdo->prepare("
            INSERT INTO village_officials (
                name, position, photo, period, is_active,
                whatsapp, facebook, email, maps_embed_url, address
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        try {
            $statement->execute([
                $official->name,
                $official->position,
                $official->photo ?? null,
                $official->period,
                $official->isActive ? 1 : 0,
                $official->whatsapp ?? null,
                $official->facebook ?? null,
                $official->email ?? null,
                $official->mapsEmbedUrl ?? null,
                $official->address ?? null
            ]);

            $official->id = (int) $this->pdo->lastInsertId();

            return $official;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(VillageOfficial $official): VillageOfficial
    {
        $statement = $this->pdo->prepare("
        UPDATE village_officials
        SET
            name = ?,
            position = ?,
            photo = ?,
            period = ?,
            is_active = ?,
            whatsapp = ?,
            facebook = ?,
            email = ?,
            maps_embed_url = ?,
            address = ?,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
        AND deleted_at IS NULL
    ");

        try {
            $statement->execute([
                $official->name,
                $official->position,
                $official->photo ?? null,
                $official->period,
                $official->isActive ? 1 : 0,
                $official->whatsapp ?? null,
                $official->facebook ?? null,
                $official->email ?? null,
                $official->mapsEmbedUrl ?? null,
                $official->address ?? null,
                $official->id
            ]);

            // Set updatedAt manually
            $official->updatedAt = date('Y-m-d H:i:s');

            return $official;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(int $id): ?VillageOfficial
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM village_officials
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
            SELECT * FROM village_officials
            WHERE deleted_at IS NULL
            ORDER BY is_active DESC, created_at ASC
        ");

        try {
            $statement->execute();
            $officials = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $officials[] = $this->mapToDomain($row);
            }

            return $officials;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findActive(): array
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM village_officials
            WHERE deleted_at IS NULL
            AND is_active = 1
            ORDER BY created_at ASC
        ");

        try {
            $statement->execute();
            $officials = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $officials[] = $this->mapToDomain($row);
            }

            return $officials;
        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $statement = $this->pdo->prepare("
            UPDATE village_officials
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
        $this->pdo->exec("DELETE FROM village_officials");
    }

    private function mapToDomain(array $row): VillageOfficial
    {
        $official = new VillageOfficial();

        $official->id = (int) $row['id'];
        $official->name = $row['name'];
        $official->position = $row['position'];
        $official->photo = $row['photo'] ?? null;
        $official->period = $row['period'];
        $official->isActive = (bool) $row['is_active'];
        $official->whatsapp = $row['whatsapp'] ?? null;
        $official->facebook = $row['facebook'] ?? null;
        $official->email = $row['email'] ?? null;
        $official->mapsEmbedUrl = $row['maps_embed_url'] ?? null;
        $official->address = $row['address'] ?? null;
        $official->createdAt = $row['created_at'] ?? null;
        $official->updatedAt = $row['updated_at'] ?? null;
        $official->deletedAt = $row['deleted_at'] ?? null;

        return $official;
    }
}