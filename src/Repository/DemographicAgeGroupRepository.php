<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicAgeGroup;
use PDO;

class DemographicAgeGroupRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(DemographicAgeGroup $data): DemographicAgeGroup
    {
        $statement = $this->pdo->prepare("
            INSERT INTO demographic_age_groups (age_range, total)
            VALUES (?, ?)
        ");

        try {
            $statement->execute([
                $data->ageRange,
                $data->total
            ]);

            $data->id = (int) $this->pdo->lastInsertId();

            return $data;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(DemographicAgeGroup $data): DemographicAgeGroup
    {
        $statement = $this->pdo->prepare("
            UPDATE demographic_age_groups
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
            SELECT * FROM demographic_age_groups
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

    public function findById(int $id): ?DemographicAgeGroup
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM demographic_age_groups
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
        $this->pdo->exec("DELETE FROM demographic_age_groups");
    }

    private function mapToDomain(array $row): DemographicAgeGroup
    {
        $data = new DemographicAgeGroup();
        $data->id = (int) $row['id'];
        $data->ageRange = $row['age_range'];
        $data->total = (int) $row['total'];
        $data->updatedAt = $row['updated_at'] ?? null;

        return $data;
    }
}