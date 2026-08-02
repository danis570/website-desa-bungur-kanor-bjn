<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageHistory;
use PDO;

class VillageHistoryRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(VillageHistory $history): VillageHistory
    {
        $statement = $this->pdo->prepare("
            INSERT INTO village_histories (year, title, image, description)
            VALUES (?, ?, ?, ?)
        ");

        try {
            $statement->execute([
                $history->year,
                $history->title,
                $history->image ?? null,
                $history->description
            ]);

            $history->id = (int) $this->pdo->lastInsertId();

            return $history;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(VillageHistory $history): VillageHistory
    {
        $statement = $this->pdo->prepare("
        UPDATE village_histories
        SET
            year = ?,
            title = ?,
            image = ?,
            description = ?,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
        AND deleted_at IS NULL
    ");

        try {
            $statement->execute([
                $history->year,
                $history->title,
                $history->image ?? null,
                $history->description,
                $history->id
            ]);

            // Set updatedAt manually
            $history->updatedAt = date('Y-m-d H:i:s');

            return $history;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(int $id): ?VillageHistory
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM village_histories
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
            SELECT * FROM village_histories
            WHERE deleted_at IS NULL
            ORDER BY year DESC
        ");

        try {
            $statement->execute();
            $histories = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $histories[] = $this->mapToDomain($row);
            }

            return $histories;
        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $statement = $this->pdo->prepare("
            UPDATE village_histories
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
        $this->pdo->exec("DELETE FROM village_histories");
    }

    private function mapToDomain(array $row): VillageHistory
    {
        $history = new VillageHistory();

        $history->id = (int) $row['id'];
        $history->year = (int) $row['year'];
        $history->title = $row['title'];
        $history->image = $row['image'] ?? null;
        $history->description = $row['description'];
        $history->createdAt = $row['created_at'] ?? null;
        $history->updatedAt = $row['updated_at'] ?? null;
        $history->deletedAt = $row['deleted_at'] ?? null;

        return $history;
    }
}