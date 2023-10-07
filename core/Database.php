<?php

namespace app\core;

use app\models\User;
use PDO;

class Database
{
    public \PDO $pdo;
    public static Database $db;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=Base', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db = $this;
    }

    public function getAccountById(int $id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM User WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAccountByUsernameOrEmail(string $username, string $email)
    {
        $statement = $this->pdo->prepare("SELECT * FROM User WHERE username = :username OR email = :email");
        $statement->bindValue(":username", $username);
        $statement->bindValue(":email", $email);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAccount(User $user): void
    {
        $statement = $this->pdo->prepare("UPDATE User SET title = :title,
                                            firstname = :firstname,
                                            lastname = :lastname,
                                            dob = :dob,
                                            image = :image,
                                            phone = :phone,
                                            address = :address
                                            WHERE id = :id");

        $statement->bindValue(":id", $user->id);
        $statement->bindValue(":title", $user->title);
        $statement->bindValue(":firstname", $user->firstName);
        $statement->bindValue(":lastname", $user->lastName);
        $statement->bindValue(":dob", $user->dob);
        $statement->bindValue(":image", $user->image);
        $statement->bindValue(":phone", $user->phone);
        $statement->bindValue(":address", $user->address);

        $statement->execute();
    }

    public function getAccountByEmail(string $email)
    {
        $statement = $this->pdo->prepare("SELECT * FROM User WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createAccount(User $user): void
    {
        $passwordHash = password_hash($user->password, PASSWORD_DEFAULT);
        $statement = $this->pdo->prepare("INSERT INTO User (username, email, password)
                                VALUES (:username, :email, :password)");
        $statement->bindValue(":username", $user->username);
        $statement->bindValue(":email", $user->email);
        $statement->bindValue(":password", $passwordHash);
        $statement->execute();
    }
}