<?php

namespace app\models;

use app\core\Database;
use app\core\Model;

class User extends Model {
    public static $db = "User";
    public static $fields = ["id", "full_name", "title", "username", "password", "email", "image", "dob", "phone", "address"];

    public ?int $id = null;
    public $full_name;
    public $title;
    public $username;
    public $password;
    public $email;
    public $image;
    public $dob;
    public $phone;
    public $address;

    public function save(): void {
        $db = Database::$db;
        if($this->id){
            $db->updateAccount($this);
        } else {
            $db->createAccount($this);
        }
    }


}
