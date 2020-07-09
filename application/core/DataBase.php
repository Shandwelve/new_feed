<?php

namespace application\core;

use PDO;
use PDOException;

class DataBase
{
    private static object $instance;

    private object $connection;

    public static function getInstance(): object
    {
        return self::$instance ??= new self();
    }

    public function connect(array $config): bool
    {
        try {
            $this->connection = new PDO("{$config['driver']}:host={$config['host']};dbname={$config['name']}",
                $config['username'], $config['password']);
        } catch (PDOException $exception) {
            die('Connection error: ' . $exception->getMessage());
        }
        return true;
    }

    public function query(string $sql, array $params = []): object
    {
        $statement = $this->connection->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $statement->bindValue(":$key", $value);
            }
        }

        $statement->execute();

        return $statement;

    }

    public function row(string $sql, array $params = []): array
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column(string $sql, array $params = []): ?string
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    public function lastInsertId(): int
    {
        return $this->connection->lastInsertId();
    }
}