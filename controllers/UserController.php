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
//            echo "12345";
//            exit();
        }
        return $router->renderView('login');
    }

    public function update()
    {
        session_start();

        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=base', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $id = $_SESSION['user_id'];
        $statement = $pdo->prepare('SELECT * FROM user WHERE id = :id');
        $statement->bindValue(":id", $id);
        $statement->execute();
        $user = $statement->fetchAll(PDO::FETCH_ASSOC);


        $title = $user[0]['title'] ?? null;
        $address = $user[0]['address'] ?? null;
        $phone = $user[0]['phone'] ?? null;
        $dob = $user[0]['dob'] ?? null;
        $imagePath = $user[0]['image'] ?? null;
        $firstName = $user[0]['firstname'] ?? null;
        $lastName = $user[0]['lastname'] ?? null;

        if($user[0]['dob']){
            $dob = $user[0]['dob'];
            $birthParts = explode("/", $dob);
            $day = $birthParts[0];
            $month = $birthParts[1];
            $year = $birthParts[2];
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $response = [
                "success" => "",
                "message" => ""
            ];

            $firstName = $_POST['first-name'];
            $lastName = $_POST['last-name'];
            $title = $_POST['title'];
            $address = $_POST['address'];
            $phone = $_POST['phone'];
            $day = $_POST['day'];
            $month = $_POST['month'];
            $year = $_POST['year'];

            if(!$firstName){
                $errors[] = 'FIRST NAME EMPTY';
                $response["success"] = 0;
                $response["message"] = "FIRST NAME EMPTY";
            }
            if(!$lastName){
                $errors[] = 'LAST NAME EMPTY';
                $response["success"] = 0;
                $response["message"] = "LAST NAME EMPTY";
            }

            $dob = $day."/".$month."/".$year;

            if(empty($errors)){
                if(!is_dir('images')) {
                    mkdir('images');
                }

                if($_FILES['image']['name']){
                    $imagePath = 'images/' . randomString(8) . '/' . $_FILES['image']['name'];
                    mkdir(dirname($imagePath));
                } else {
                    $imagePath = $user[0]['image'];
                }
                if($imagePath) {
                    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
                }


                $response["success"] = 1;
                $statement = $pdo->prepare("UPDATE user SET title = :title,
                                            firstname = :firstname,
                                            lastname = :lastname,
                                            dob = :dob,
                                            image = :image,
                                            phone = :phone,
                                            address = :address
                                            WHERE id = :id");

                $statement->bindValue(":id", $id);
                $statement->bindValue(":title", $title);
                $statement->bindValue(":firstname", $firstName);
                $statement->bindValue(":lastname", $lastName);
                $statement->bindValue(":dob", $dob);
                $statement->bindValue(":image", $imagePath);
                $statement->bindValue(":phone", $phone);
                $statement->bindValue(":address", $address);

                $statement->execute();
                //header("Location: account.php");
            }
            echo json_encode($response);
        }
    }

    public function account(Router $router)
    {
        session_start();

        //if(!isset($_SESSION['user_email'])) {
        //    header("Location: login.php");
        //}
        //else {
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=base', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$id = $_SESSION['user_id'];
        $statement = $pdo->prepare('SELECT * FROM user WHERE id = 1');
        //$statement->bindValue(":id", $id);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $router->renderView('account', $user);
//}
    }


}