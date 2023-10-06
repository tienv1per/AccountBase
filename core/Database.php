<?php

namespace app\core;

use PDO;

class Database
{
    public \PDO $pdo;
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=base', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAccount(int $id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM user WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}