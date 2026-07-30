<?php

namespace Kkn27Unirow\WebsiteDesaBungur\Config;

class Database
{
    private static ?\PDO $pdo = null;

    public static function getConnection(string $env = "dev"): \PDO
    {
        if (self::$pdo == null) {
            // create new PDO
            require_once __DIR__ . '/../../config/connection.php';
            $config = getDatabaseConfig();
            self::$pdo = new \PDO(
                $config['database'][$env]['dsn'],
                $config['database'][$env]['username'],
                $config['database'][$env]['password']
            );
        }

        return self::$pdo;
    }

    public static function beginTransaction()
    {
        self::$pdo->beginTransaction();
    }

    public static function commitTransaction()
    {
        self::$pdo->commit();
    }

    public static function rollbackTransaction()
    {
        self::$pdo->rollBack();
    }
}