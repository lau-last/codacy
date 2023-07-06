<?php

namespace App\Database;

use PDO;

final class DBConnect
{
    private static ?PDO $pdo = null;

    /**
     * @return PDO
     */
    public static function getPDO(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO(DATABASE_DNS, DATABASE_USER, DATABASE_PASSWORD);
        }
        return self::$pdo;
    }
}
