<?php

namespace app\controllers;
use app\core\Router;
use PDO;

require_once '../views/functions.php';

class UserController
{
    public function signup(Router $router)
    {
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=base', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $salt = "tobiasnguyen";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!$username) {
                $errors[] = 'Username empty. Please enter your username';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email ''. Please try again.";
            }

            if (!$password) {
                $errors[] = 'Password empty. Please enter your password';
            }

            if (empty($errors)) {
                $statement = $pdo->prepare("SELECT * FROM user WHERE username = :username OR email = :email");
                $statement->bindValue(":username", $username);
                $statement->bindValue(":email", $email);
                $statement->execute();
                $existUser = $statement->fetchAll(PDO::FETCH_ASSOC);

                if ($existUser) {
                    $errors[] = "Username or password has already exist.";
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $statementAdd = $pdo->prepare("INSERT INTO user (username, email, password)
                                VALUES (:username, :email, :password)");
                    $statementAdd->bindValue(":username", $username);
                    $statementAdd->bindValue(":email", $email);
                    $statementAdd->bindValue(":password", $passwordHash);
                    $statementAdd->execute();
                    header("Location: /login");
                    exit;
                }
            }
        }

        return $router->renderView('signup');
    }

    public function login(Router $router)
    {

        session_start();

        if (!isset($_SESSION['user_email'])) {
            $pdo = new PDO('mysql:host=localhost;port=3306;dbname=base', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $errors = [];
                $email = $_POST['email'];
                $password = $_POST['password'];

                if (isset($_POST['submit'])) {
                    $secret = getEnvVar('SECRET_CAPTCHA_SERVER');
                    $response = $_POST['g-recaptcha-response'];
                    $remoteip = $_SERVER['REMOTE_ADDR'];
                    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
                    $data = file_get_contents($url);
                    $row = json_decode($data, true);
//            if ($row['success'] == "true") {
//                echo "<script>alert('Wow you are not a robot 😲');</script>";
//            } else {
//                echo "<script>alert('Oops you are a robot 😡');</script>";
//            }
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = "Invalid email ''. Please try again.";
                }
                if (!$password) {
                    $errors[] = 'Mật khẩu không hợp lệ. Vui lòng thử lại.';
                }

                if (empty($errors)) {
                    $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
                    $statement->bindValue(":email", $email);
                    $statement->execute();
                    $user = $statement->fetchAll(PDO::FETCH_ASSOC);

                    if ($user) {
                        $passwordUser = $user[0]['password'];
                        if (password_verify($password, $passwordUser)) {
                            $_SESSION['user_id'] = $user[0]['id'];
                            $_SESSION['user_email'] = $user[0]['email'];
                            setcookie(session_name(), $_COOKIE[session_name()], time() + 24 * 60 * 60 * 7);
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
//    echo "12345";
//    exit();
        }
        return $router->renderView('login');
    }

    public function update()
    {

    }
}