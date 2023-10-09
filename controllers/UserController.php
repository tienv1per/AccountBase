<?php

namespace app\controllers;
use app\core\Router;
use app\models\User;
use app\models\Validator;

require_once '../utils/functions.php';

class UserController {
    public function signup(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_data = $router->request->getPostData();
            $validator = new Validator();
            $errors = $validator->validate($post_data);

            if(!preg_match('/^[a-zA-Z0-9_]+$/', $post_data['username'])){
                $errors[] = "Username must not have space.";
            }

            if (empty($errors)) {
                $user = new User();
                $user->load($post_data);
                $existUser = User::getByUsernameOrEmail($post_data['username'], $post_data['email']);

                if ($existUser->id) {
                    $errors[] = "Username or email has already exist.";
                } else {
                    $user->createData();
                    header("Location: /login");
                    exit;
                }
            }
        }

        return $router->renderView('signup', $errors);
    }

    public function login(Router $router) {
        session_start();
        if (!isset($_SESSION['email'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $post_data = $router->request->getPostData();

                $email = $post_data['email'];
                $password = $post_data['password'];

                $validator = new Validator();
                $errors = $validator->validate($post_data);
                if (empty($errors)) {
                    $user = User::getByEmail($email);

                    if ($user) {
                        if (password_verify($password, $user->password)) {
                            setCookies($user->id, $user->email);
                            header("Location: /account");
                        } else {
                            $errors[] = "Email or password not correct";
                        }
                    } else {
                        $errors[] = "Email or password not correct";
                    }
                }
            }
        } else {
            header("Location: /account");
        }
        return $router->renderView('login', $errors);
    }

    public function update(Router $router): void {
        session_start();
        $id = $_SESSION['id'];
        $user = User::getById($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $response = [
                "success" => "",
                "message" => ""
            ];

            $post_data = $router->request->getPostData();

            $validator = new Validator();
            $errors = $validator->validate($post_data);
            if(!empty($errors)){
                $response["success"] = 0;
                $response['message'] = $errors;
            }

            foreach ($post_data as $key => $value){
                if(property_exists($user, $key)){
                    $user->$key = $value;
                }
            }

            $user->dob = $post_data['day']."/".$post_data['month']."/".$post_data['year'];
            $user->full_name = $post_data['first_name']." ".$post_data['last_name'];

            if(empty($errors)){
                $imagePath = saveImages($user->image);

                $response["success"] = 1;

                $user->image = $imagePath;

                $user->updateData();
            }
            echo json_encode($response);
        }
    }

    public function account(Router $router): bool|string {
        session_start();

        if(!isset($_SESSION['email'])) {
            header("Location: /login");
        }
        else {
            $id = $_SESSION['id'];
            $user = User::getById($id);
        }

        return $router->renderView('account', $user);
    }

    public function logout(): void {
        session_start();
        session_unset();
        header("Location: /login");
    }
}
