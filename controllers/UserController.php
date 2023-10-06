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

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

        return $router->renderView('signup', $errors);
    }

    public function login(Router $router)
    {

        session_start();
        $errors = [];
        if (!isset($_SESSION['user_email'])) {
            $pdo = new PDO('mysql:host=localhost;port=3306;dbname=base', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        }
        return $router->renderView('login', $errors);
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
        $user = $statement->fetch(PDO::FETCH_ASSOC);


        $title = $user['title'] ?? null;
        $address = $user['address'] ?? null;
        $phone = $user['phone'] ?? null;
        $dob = $user['dob'] ?? null;
        $imagePath = $user['image'] ?? null;
        $firstName = $user['firstname'] ?? null;
        $lastName = $user['lastname'] ?? null;

        if($user['dob']){
            $dob = $user['dob'];
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
                    $imagePath = $user['image'];
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

        if(!isset($_SESSION['user_email'])) {
            header("Location: login.php");
        }
        else {
            $pdo = new PDO('mysql:host=localhost;port=3306;dbname=base', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $id = $_SESSION['user_id'];
            $statement = $pdo->prepare('SELECT * FROM user WHERE id = :id');
            $statement->bindValue(":id", $id);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);
        }

        return $router->renderView('account', $user);
    }

    public function logout()
    {
        session_start();
        session_unset();
        header("Location: /login");
    }
}