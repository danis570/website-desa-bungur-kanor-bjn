<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicReligion;
use PDO;

class DemographicReligionRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(DemographicReligion $data): DemographicReligion
    {
        $statement = $this->pdo->prepare("
            INSERT INTO demographic_religions (religion, total)
            VALUES (?, ?)
        ");

        try {
            $statement->execute([
                $data->religion,
                $data->total
            ]);

            $data->id = (int) $this->pdo->lastInsertId();

            return $data;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(DemographicReligion $data): DemographicReligion
    {
        $statement = $this->pdo->prepare("
            UPDATE demographic_religions
            SET total = ?
            WHERE id = ?
        ");

        try {
            $statement->execute([
                $data->total,
                $data->id
            ]);

            return $data;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findAll(): array
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM demographic_religions
            ORDER BY id ASC
        ");

        try {
            $statement->execute();
            $data = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $this->mapToDomain($row);
            }

            return $data;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(int $id): ?DemographicReligion
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM demographic_religions
            WHERE id = ?
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

    public function deleteAll(): void
    {
        $this->pdo->exec("DELETE FROM demographic_religions");
    }

    private function mapToDomain(array $row): DemographicReligion
    {
        $data = new DemographicReligion();
        $data->id = (int) $row['id'];
        $data->religion = $row['religion'];
        $data->total = (int) $row['total'];
        $data->updatedAt = $row['updated_at'] ?? null;

        return $data;
    }
}