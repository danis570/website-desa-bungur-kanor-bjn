<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Repository;

use Kkn27Unirow\WebsiteDesaBungur\Domain\Session;
use PDO;

class SessionRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Session $session): Session
    {
        $statement = $this->connection->prepare("
            INSERT INTO sessions(id, user_id)
            VALUES (?, ?)
        ");

        $statement->execute([
            $session->id,
            $session->userId
        ]);

        return $session;
    }

    public function findById(string $id): ?Session
    {
        $statement = $this->connection->prepare("
            SELECT *
            FROM sessions
            WHERE id = ?
        ");

        $statement->execute([$id]);

        try {

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return $this->mapToSession($row);

        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteById(string $id): void
    {
        $statement = $this->connection->prepare("
            DELETE FROM sessions
            WHERE id = ?
        ");

        $statement->execute([$id]);
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM sessions");
    }

    private function mapToSession(array $row): Session
    {
        $session = new Session();

        $session->id = $row['id'];
        $session->userId = (int) $row['user_id'];
        $session->createdAt = $row['created_at'];
        $session->expiredAt = $row['expired_at'];

        return $session;
    }
}