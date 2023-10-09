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

//    public function load($user): void {
//        $this->id = $user['id'] ?? null;
//        $this->username = $user['username'] ?? '';
//        $this->full_name = $user['full_name'] ?? '';
//        $this->email = $user['email'] ?? '';
//        $this->title = $user['title'] ?? '';
//        $this->password = $user['password'] ?? '';
//        $this->image = $user['image'] ?? '';
//        $this->dob = $user['dob'] ?? '';
//        $this->phone = $user['phone'] ?? '';
//        $this->address = $user['address'] ?? '';
//    }

    public function save(): void {
        $db = Database::$db;
        if($this->id){
            $db->updateAccount($this);
        } else {
            $db->createAccount($this);
        }
    }


}
