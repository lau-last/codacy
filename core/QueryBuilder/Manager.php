<?php

namespace Core\QueryBuilder;

use App\Database\DBConnect;
use PDO;

final class Manager
{

    /**
     * @param string $query
     * @param array $param
     * @return \PDOStatement
     */
    public function queryExecute(string $query, array $param = []): \PDOStatement
    {
        $stmt = DBConnect::getPDO()->prepare($query);
        if ($param !== []) {
            foreach ($param as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    /**
     * @param string $query
     * @param array $param
     * @return array
     */
    public function fetch(string $query, array $param = []): array
    {
        $stmt = $this->queryExecute($query, $param);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * @param string $query
     * @param array $param
     * @return array
     */
    public function fetchAll(string $query, array $param = []): array
    {
        $stmt = $this->queryExecute($query, $param);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

}