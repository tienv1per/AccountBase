<?php

namespace app\models;

class Validator {
    public function validate($post_data): array {
        $errors = [];
        // validate for user input form update
        if($_SERVER['REQUEST_URI'] === '/update') {
            if(!$post_data['first_name']){
                $errors[] = 'FIRST NAME EMPTY';
            }
            if(!$post_data['last_name']){
                $errors[] = 'LAST NAME EMPTY';
            }
        }
        // validate for user input login, signup
        else {
            if (!$post_data['username'] and $_SERVER['PATH_INFO'] === '/signup') {
                $errors[] = 'Username empty. Please enter your username';
            }
            if (!filter_var($post_data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email ''. Please try again.";
            }
            if (!$post_data['password']) {
                $errors[] = 'Password empty. Please enter your password';
            }
        }

        return $errors;
    }
}