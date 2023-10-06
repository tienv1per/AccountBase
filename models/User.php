<?php

namespace app\models;

class User
{
    public ?int $id = null;
    public string $firstName;
    public string $lastName;
    public string $title;
    public string $username;
    public string $password;
    public string $email;
    public string $image;
    public string $dob;
    public string $phone;
    public string $address;

    public function load($user)
    {
        $this->id = $user['id']  ?? null;
        $this->username = $user['username'];
        $this->firstName = $user['firstName'] ?? null;
        $this->lastName = $user['lastName'] ?? null;
        $this->email = $user['email'];
        $this->image = $user['image'] ?? null;
        $this->dob = $user['dob'] ?? null;
        $this->phone = $user['phone'] ?? null;
        $this->address = $user['address'] ?? null;
    }
}