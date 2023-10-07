<?php

namespace app\controllers;
use app\core\Router;
use app\models\User;

require_once '../utils/functions.php';

class UserController {
    public function signup(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userData['username'] = $_POST['username'];
            $userData['email'] = $_POST['email'];
            $userData['password'] = $_POST['password'];

            if (!$userData['username']) {
                $errors[] = 'Username empty. Please enter your username';
            }
            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email ''. Please try again.";
            }

            if (!$userData['password']) {
                $errors[] = 'Password empty. Please enter your password';
            }

            if (empty($errors)) {
                $user = new User();
                $user->load($userData);
                $existUser = $router->database->getAccountByUsernameOrEmail($userData['username'], $userData['email']);

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

    public function login(Router $router): bool|string {
        session_start();
        if (!isset($_SESSION['email'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $email = $_POST['email'];
                $password = $_POST['password'];

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Invalid email ''. Please try again.";
                }
                if (!$password) {
                    $errors[] = 'Mật khẩu không hợp lệ. Vui lòng thử lại.';
                }
;
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
        $id = $_SESSION['user_id'];

        $user = $router->database->getAccountById($id);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $response = [
                "success" => "",
                "message" => ""
            ];

            $userData['id'] = $user['id'];
            $userData['firstName'] = $_POST['first-name'];
            $userData['lastName'] = $_POST['last-name'];
            $userData['title'] = $_POST['title'];
            $userData['address'] = $_POST['address'];
            $userData['phone'] = $_POST['phone'];
            $userData['day'] = $_POST['day'];
            $userData['month'] = $_POST['month'];
            $userData['year'] = $_POST['year'];

            if(!$userData['firstName']){
                $errors[] = 'FIRST NAME EMPTY';
                $response["success"] = 0;
                $response["message"] = "FIRST NAME EMPTY";
            }
            if(!$userData['lastName']){
                $errors[] = 'LAST NAME EMPTY';
                $response["success"] = 0;
                $response["message"] = "LAST NAME EMPTY";
            }

            $userData['dob'] = $userData['day']."/".$userData['month']."/".$userData['year'];

            if(empty($errors)){
                $imagePath = saveImages($user['image']);

                $response["success"] = 1;

                $userData['image'] = $imagePath;

                $userUpdate = new User();
                $userUpdate->load($userData);
                $userUpdate->save();
            }
            echo json_encode($response);
        }
    }

    public function account(Router $router): bool|string {
        session_start();

        if(!isset($_SESSION['user_email'])) {
            header("Location: /login");
        }
        else {
            $id = $_SESSION['user_id'];
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
