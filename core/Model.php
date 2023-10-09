<?php

namespace app\core;

use PDO;

class Model
{
    public static $database; // connection
    public static $db; // name database
    public static $fields;
    public static function getDb()
    {
        if(!self::$database) {
            self::$database = new Database();
        }
        return self::$database;
    }

    public function load($data): void {
        foreach ($data as $key => $value){
            if($value === null){
                continue;
            }
            $this->{$key} = $value;
        }
    }

    public static function getById(int $id) {
        $db = static::$db;
        $statement = self::getDb()->pdo->prepare("SELECT * FROM {$db} WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();

        $dataReturn = $statement->fetch(PDO::FETCH_ASSOC);
        $model = new static(); // luu constructor cua class dang goi ham
        $model->load($dataReturn);
        return $model;
    }

    public static function getByEmail(string $email)
    {
        $db = static::$db;
        $statement = self::getDb()->pdo->prepare("SELECT * FROM {$db} WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();

        $dataReturn = $statement->fetch(PDO::FETCH_ASSOC);
        $model = new static(); // luu constructor cua class dang goi ham
        $model->load($dataReturn);
        return $model;
    }

    public function updateData(): void {
        $db = static::$db;
        $fields = static::$fields;
        $query = "UPDATE {$db} SET ";
        foreach ($fields as $field){
            $query .= "{$field} = :{$field}, ";
        }

        $query = rtrim($query, ", ");
        $query .= " WHERE id = :id";
        $statement = self::getDb()->pdo->prepare($query);

        foreach ($fields as $field){
            if(property_exists($this, $field)){
                $statement->bindValue(":{$field}", $this->$field);
            }
        }
        $statement->bindValue(":id", $this->id);
        $statement->execute();
    }
}