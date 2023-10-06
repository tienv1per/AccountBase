<?php

namespace app\core;

use app\models\User;
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

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAccount(User $user)
    {
        
    }

    public function getAccountByEmail(string $email)
    {
        $statement = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createAccount(User $user, string $passwordHash)
    {
        $statement = $this->pdo->prepare("INSERT INTO user (username, email, password)
                                VALUES (:username, :email, :password)");
        $statement->bindValue(":username", $user->username);
        $statement->bindValue(":email", $user->email);
        $statement->bindValue(":password", $passwordHash);
        $statement->execute();
    }
}