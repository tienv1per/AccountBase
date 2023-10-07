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

            if (empty($errors)) {
                $user = new User();
                $user->load($post_data);
                $existUser = $router->database->getAccountByUsernameOrEmail($post_data['username'], $post_data['email']);

                if ($existUser) {
                    $errors[] = "Username or password has already exist.";
                } else {
                    $user->save();
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
                    $user = $router->database->getAccountByEmail($email);

                    if ($user) {
                        if (password_verify($password, $user['password'])) {
                            setCookies($user['id'], $user['email']);
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

        $user = $router->database->getAccountById($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $response = [
                "success" => "",
                "message" => ""
            ];

            $post_data = $router->request->getPostData();
            $post_data['id'] = $user['id'];
            $validator = new Validator();
            $errors = $validator->validate($post_data);
            if(!empty($errors)){
                $response["success"] = 0;
                $response['message'] = $errors;
            }

            $post_data['dob'] = $post_data['day']."/".$post_data['month']."/".$post_data['year'];

            if(empty($errors)){
                $imagePath = saveImages($user['image']);

                $response["success"] = 1;

                $post_data['image'] = $imagePath;

                $userUpdate = new User();
                $userUpdate->load($post_data);
                $userUpdate->save();
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
            $user = $router->database->getAccountById($id);
        }

        return $router->renderView('account', $user);
    }

    public function logout(): void {
        session_start();
        session_unset();
        header("Location: /login");
    }
}
