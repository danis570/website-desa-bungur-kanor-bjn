<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\VillageGreeting;
use PDO;

class VillageGreetingRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(VillageGreeting $greeting): VillageGreeting
    {
        $statement = $this->pdo->prepare("
            INSERT INTO village_greetings (
                name, opening, content, closing, image, signature_image
            )
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        try {
            $statement->execute([
                $greeting->name,
                $greeting->opening ?? null,
                $greeting->content ?? null,
                $greeting->closing ?? null,
                $greeting->image ?? null,
                $greeting->signatureImage ?? null
            ]);

            $greeting->id = (int) $this->pdo->lastInsertId();

            return $greeting;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(VillageGreeting $greeting): VillageGreeting
    {
        $statement = $this->pdo->prepare("
            UPDATE village_greetings
            SET
                name = ?,
                opening = ?,
                content = ?,
                closing = ?,
                image = ?,
                signature_image = ?,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = ?
            AND deleted_at IS NULL
        ");

        try {
            $statement->execute([
                $greeting->name,
                $greeting->opening ?? null,
                $greeting->content ?? null,
                $greeting->closing ?? null,
                $greeting->image ?? null,
                $greeting->signatureImage ?? null,
                $greeting->id
            ]);

            $greeting->updatedAt = date('Y-m-d H:i:s');

            return $greeting;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(int $id): ?VillageGreeting
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM village_greetings
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

    public function findFirst(): ?VillageGreeting
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM village_greetings
            WHERE deleted_at IS NULL
            ORDER BY id ASC
            LIMIT 1
        ");

        try {
            $statement->execute();
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
            SELECT * FROM village_greetings
            WHERE deleted_at IS NULL
            ORDER BY created_at DESC
        ");

        try {
            $statement->execute();
            $greetings = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $greetings[] = $this->mapToDomain($row);
            }

            return $greetings;
        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $statement = $this->pdo->prepare("
            UPDATE village_greetings
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
        $this->pdo->exec("DELETE FROM village_greetings");
    }

    private function mapToDomain(array $row): VillageGreeting
    {
        $greeting = new VillageGreeting();

        $greeting->id = (int) $row['id'];
        $greeting->name = $row['name'];
        $greeting->opening = $row['opening'] ?? null;
        $greeting->content = $row['content'] ?? null;
        $greeting->closing = $row['closing'] ?? null;
        $greeting->image = $row['image'] ?? null;
        $greeting->signatureImage = $row['signature_image'] ?? null;
        $greeting->createdAt = $row['created_at'] ?? null;
        $greeting->updatedAt = $row['updated_at'] ?? null;
        $greeting->deletedAt = $row['deleted_at'] ?? null;

        return $greeting;
    }
}