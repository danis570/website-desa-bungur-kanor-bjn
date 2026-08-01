<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\UmkmMenu;
use PDO;

class UmkmMenuRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(UmkmMenu $menu): UmkmMenu
    {
        $statement = $this->pdo->prepare("
            INSERT INTO umkm_menus (umkm_id, name, image, price)
            VALUES (?, ?, ?, ?)
        ");

        try {
            $statement->execute([
                $menu->umkmId,
                $menu->name,
                $menu->image ?? null,
                $menu->price
            ]);

            $menu->id = (int) $this->pdo->lastInsertId();

            return $menu;
        } finally {
            $statement->closeCursor();
        }
    }

    public function update(UmkmMenu $menu): UmkmMenu
    {
        $statement = $this->pdo->prepare("
        UPDATE umkm_menus
        SET
            name = ?,
            image = ?,
            price = ?,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
        AND deleted_at IS NULL
    ");

        try {
            $statement->execute([
                $menu->name,
                $menu->image ?? null,
                $menu->price,
                $menu->id
            ]);

            // Ambil data terbaru setelah update
            return $this->findById($menu->id) ?? $menu;
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(int $id): ?UmkmMenu
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM umkm_menus
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

            return $this->mapToMenu($row);
        } finally {
            $statement->closeCursor();
        }
    }

    public function findByUmkmId(int $umkmId): array
    {
        $statement = $this->pdo->prepare("
            SELECT * FROM umkm_menus
            WHERE umkm_id = ?
            AND deleted_at IS NULL
            ORDER BY created_at ASC
        ");

        try {
            $statement->execute([$umkmId]);
            $menus = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $menus[] = $this->mapToMenu($row);
            }

            return $menus;
        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $statement = $this->pdo->prepare("
            UPDATE umkm_menus
            SET deleted_at = CURRENT_TIMESTAMP
            WHERE id = ?
        ");

        try {
            $statement->execute([$id]);
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteByUmkmId(int $umkmId): void
    {
        $statement = $this->pdo->prepare("
            UPDATE umkm_menus
            SET deleted_at = CURRENT_TIMESTAMP
            WHERE umkm_id = ?
        ");

        try {
            $statement->execute([$umkmId]);
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $this->pdo->exec("DELETE FROM umkm_menus");
    }

    private function mapToMenu(array $row): UmkmMenu
    {
        $menu = new UmkmMenu();

        $menu->id = (int) $row['id'];
        $menu->umkmId = (int) $row['umkm_id'];
        $menu->name = $row['name'];
        $menu->image = $row['image'] ?? null;
        $menu->price = (float) $row['price'];
        $menu->createdAt = $row['created_at'] ?? null;
        $menu->updatedAt = $row['updated_at'] ?? null;
        $menu->deletedAt = $row['deleted_at'] ?? null;

        return $menu;
    }
}