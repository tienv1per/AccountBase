<?php
require_once 'functions.php';


$pdo = new PDO('mysql:host=localhost;port=3306;dbname=base', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $pdo->prepare('SELECT * FROM user WHERE id = 1');
$statement->execute();
$user = $statement->fetchAll(PDO::FETCH_ASSOC);

$title = $user[0]['title'];
$address = $user[0]['address'];
$phone = $user[0]['phone'];
$dob = $user[0]['dob'];
$image = $user[0]['image'] ?? null;
$firstName = $user[0]['firstname'];
$lastName = $user[0]['lastname'];
$birthParts = explode("/", $dob);
$day = $birthParts[0];
$month = $birthParts[1];
$year = $birthParts[2];


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
    $image = $_FILES['image'] ?? null;

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
        $imagePath = '';
        if(!is_dir('images')) {
            mkdir('images');
        }
        if ($image && $image['tmp_name']) {
            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
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

        $statement->bindValue(":id", 1);
        $statement->bindValue(":title", $title);
        $statement->bindValue(":firstname", $firstName);
        $statement->bindValue(":lastname", $lastName);
        $statement->bindValue(":dob", $dob);
        $statement->bindValue(":image", $imagePath);
        $statement->bindValue(":phone", $phone);
        $statement->bindValue(":address", $address);

        $statement->execute();
        header("Location: account.php");
    }

    echo json_encode($response);
}