<?php

namespace App\Core\Storage;

use PDO;

class Database
{
    protected $pdo;

    /**
     * Database constructor.
     *
     * @param string $host
     * @param string $database
     * @param string $user
     * @param string $password
     * @param string $charset
     */
    public function __construct(
        string $host,
        string $database,
        string $user,
        string $password,
        string $charset = 'utf8'
    ) {
        $dsn = "mysql:host=$host;dbname=$database;charset=$charset";

        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $this->pdo = new PDO($dsn, $user, $password, $opt);
    }

    public function selectManyRaw($query, $bindings = [])
    {
        $stmt = $this->pdo->prepare($query);

        $stmt->execute($bindings);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectOneRaw($query, $bindings = [])
    {
        $stmt = $this->pdo->prepare($query);

        $stmt->execute($bindings);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}