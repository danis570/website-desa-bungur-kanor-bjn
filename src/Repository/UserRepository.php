<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\User;
use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(User $user): User
    {
        $statement = $this->pdo->prepare("
            INSERT INTO users (
                name,
                email,
                password,
                avatar,
                position,
                role
            )
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        try {

            $statement->execute([
                $user->name,
                $user->email,
                $user->password,
                $user->avatar,
                $user->position,
                $user->role
            ]);

            $user->id = (int) $this->pdo->lastInsertId();

            return $user;

        } finally {
            $statement->closeCursor();
        }
    }

    public function update(User $user): User
    {
        $statement = $this->pdo->prepare("
        UPDATE users
        SET
            name = ?,
            email = ?,
            password = ?,
            avatar = ?,
            position = ?,
            role = ?,
            updated_at = CURRENT_TIMESTAMP
        WHERE id = ?
        AND deleted_at IS NULL
    ");

        $statement->execute([
            $user->name,
            $user->email,
            $user->password,
            $user->avatar,
            $user->position,
            $user->role,
            $user->id
        ]);

        return $user;
    }

    public function findById(int $id): ?User
    {
        $statement = $this->pdo->prepare("
            SELECT *
            FROM users
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

            return $this->mapToUser($row);

        } finally {
            $statement->closeCursor();
        }
    }

    public function findByEmail(string $email): ?User
    {
        $statement = $this->pdo->prepare("
            SELECT *
            FROM users
            WHERE email = ?
              AND deleted_at IS NULL
            LIMIT 1
        ");

        try {

            $statement->execute([$email]);

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return $this->mapToUser($row);

        } finally {
            $statement->closeCursor();
        }
    }

    public function findAll(): array
    {
        $statement = $this->pdo->prepare("
        SELECT *
        FROM users
        WHERE deleted_at IS NULL
        ORDER BY created_at DESC, id DESC
    ");

        try {

            $statement->execute();

            $users = [];

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $users[] = $this->mapToUser($row);
            }

            return $users;

        } finally {
            $statement->closeCursor();
        }
    }

    public function softDelete(int $id): void
    {
        $user = $this->findById($id);

        if ($user == null) {
            return;
        }

        $statement = $this->pdo->prepare("
        UPDATE users
        SET
            email = ?,
            deleted_at = CURRENT_TIMESTAMP
        WHERE id = ?
    ");

        $statement->execute([
            "deleted_" . $id . "_" . $user->email,
            $id
        ]);
    }

    public function deleteAll(): void
    {
        $this->pdo->exec("DELETE FROM users");
    }

    private function mapToUser(array $row): User
    {
        $user = new User();

        $user->id = (int) $row['id'];
        $user->name = $row['name'];
        $user->email = $row['email'];
        $user->password = $row['password'];
        $user->avatar = $row['avatar'];
        $user->position = $row['position'];
        $user->role = $row['role'];
        $user->createdAt = $row['created_at'];
        $user->updatedAt = $row['updated_at'];
        $user->deletedAt = $row['deleted_at'];

        return $user;
    }
}