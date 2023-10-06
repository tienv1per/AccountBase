<?php
session_start();
require_once 'functions.php';

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