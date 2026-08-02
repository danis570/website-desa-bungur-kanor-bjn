<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageVisionMission;
use PDO;

class VillageVisionMissionRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(VillageVisionMission $item): VillageVisionMission
    {
        $statement = $this->pdo->prepare("
            INSERT INTO village_visions_missions (type, description, sort_order)
            VALUES (?, ?, ?)
        ");

        try {
            $statement->execute([
                $item->type,
                $item->description,
                $item->sortOrder
            ]);

            $item->id = (int) $this->pdo->lastInsertId();

            return $item;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(VillageVisionMission $item): VillageVisionMission
    {
        $statement = $this->pdo->prepare("
        UPDATE village_visions_missions
        SET
            type = ?,
            description = ?,
            sort_order = ?,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
        AND deleted_at IS NULL
    ");

        try {
            $statement->execute([
                $item->type,
                $item->description,
                $item->sortOrder,
                $item->id
            ]);

            // Set updatedAt manually
            $item->updatedAt = date('Y-m-d H:i:s');

            return $item;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(int $id): ?VillageVisionMission
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM village_visions_missions
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
            SELECT * FROM village_visions_missions
            WHERE deleted_at IS NULL
            ORDER BY 
                FIELD(type, 'vision', 'mission'),
                sort_order ASC,
                id ASC
        ");

        try {
            $statement->execute();
            $items = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $items[] = $this->mapToDomain($row);
            }

            return $items;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findByType(string $type): array
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM village_visions_missions
            WHERE deleted_at IS NULL
            AND type = ?
            ORDER BY sort_order ASC, id ASC
        ");

        try {
            $statement->execute([$type]);
            $items = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $items[] = $this->mapToDomain($row);
            }

            return $items;
        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $statement = $this->pdo->prepare("
            UPDATE village_visions_missions
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
        $this->pdo->exec("DELETE FROM village_visions_missions");
    }

    private function mapToDomain(array $row): VillageVisionMission
    {
        $item = new VillageVisionMission();

        $item->id = (int) $row['id'];
        $item->type = $row['type'];
        $item->description = $row['description'];
        $item->sortOrder = (int) $row['sort_order'];
        $item->createdAt = $row['created_at'] ?? null;
        $item->updatedAt = $row['updated_at'] ?? null;
        $item->deletedAt = $row['deleted_at'] ?? null;

        return $item;
    }
}