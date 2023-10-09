<?php

namespace app\models;

use app\core\Database;

class User {
    public ?int $id = null;
    public string $full_name;
    public string $title;
    public string $username;
    public string $password;
    public string $email;
    public string $image;
    public string $dob;
    public string $phone;
    public string $address;

    public function load($user): void {
        $this->id = $user['id'] ?? null;
        $this->username = $user['username'] ?? '';
        $this->full_name = $user['full_name'] ?? '';
        $this->email = $user['email'] ?? '';
        $this->title = $user['title'] ?? '';
        $this->password = $user['password'] ?? '';
        $this->image = $user['image'] ?? '';
        $this->dob = $user['dob'] ?? '';
        $this->phone = $user['phone'] ?? '';
        $this->address = $user['address'] ?? '';
    }

    public function save(): void {
        $db = Database::$db;
        if($this->id){
            $db->updateAccount($this);
        } else {
            $db->createAccount($this);
        }
    }
}
