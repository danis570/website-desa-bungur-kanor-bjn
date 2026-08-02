<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\DemographicGender;
use PDO;

class DemographicGenderRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(DemographicGender $data): DemographicGender
    {
        // Cek apakah data sudah ada
        $existing = $this->findByGender($data->gender);
        
        if ($existing !== null) {
            // Update jika sudah ada
            $data->id = $existing->id;
            return $this->update($data);
        }
        
        // Insert jika belum ada
        $statement = $this->pdo->prepare("
            INSERT INTO demographic_genders (gender, total)
            VALUES (?, ?)
        ");

        try {
            $statement->execute([
                $data->gender,
                $data->total
            ]);

            $data->id = (int) $this->pdo->lastInsertId();

            return $data;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(DemographicGender $data): DemographicGender
    {
        $statement = $this->pdo->prepare("
            UPDATE demographic_genders
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
            SELECT * FROM demographic_genders
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

    public function findByGender(string $gender): ?DemographicGender
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM demographic_genders
            WHERE gender = ?
            LIMIT 1
        ");

        try {
            $statement->execute([$gender]);
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
        $this->pdo->exec("DELETE FROM demographic_genders");
    }

    private function mapToDomain(array $row): DemographicGender
    {
        $data = new DemographicGender();
        $data->id = (int) $row['id'];
        $data->gender = $row['gender'];
        $data->total = (int) $row['total'];
        $data->updatedAt = $row['updated_at'] ?? null;

        return $data;
    }
}