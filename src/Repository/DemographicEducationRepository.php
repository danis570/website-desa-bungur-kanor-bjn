<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicEducation;
use PDO;

class DemographicEducationRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(DemographicEducation $data): DemographicEducation
    {
        $statement = $this->pdo->prepare("
            INSERT INTO demographic_educations (education_level, total)
            VALUES (?, ?)
        ");

        try {
            $statement->execute([
                $data->educationLevel,
                $data->total
            ]);

            $data->id = (int) $this->pdo->lastInsertId();

            return $data;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(DemographicEducation $data): DemographicEducation
    {
        $statement = $this->pdo->prepare("
            UPDATE demographic_educations
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
            SELECT * FROM demographic_educations
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

    public function findById(int $id): ?DemographicEducation
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM demographic_educations
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
        $this->pdo->exec("DELETE FROM demographic_educations");
    }

    private function mapToDomain(array $row): DemographicEducation
    {
        $data = new DemographicEducation();
        $data->id = (int) $row['id'];
        $data->educationLevel = $row['education_level'];
        $data->total = (int) $row['total'];
        $data->updatedAt = $row['updated_at'] ?? null;

        return $data;
    }
}