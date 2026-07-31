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
    }

    public function findById(int $id): ?User
    {
        $statement = $this->pdo->prepare("
        SELECT *
        FROM users
        WHERE id = ?
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

    public function deleteAll(): void
    {
        $this->pdo->exec("DELETE FROM users");
    }
}
