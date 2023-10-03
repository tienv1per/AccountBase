<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=base', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$salt = "tobiasnguyen";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $errors = [];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!$username){
        $errors[] = 'Username empty. Please enter your username';
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Invalid email ''. Please try again.";
    }

    if(!$password){
        $errors[] = 'Password empty. Please enter your password';
    }

    if(empty($errors)){
        $statement = $pdo->prepare("SELECT * FROM user WHERE username = :username OR email = :email");
        $statement->bindValue(":username", $username);
        $statement->bindValue(":email", $email);
        $statement->execute();
        $existUser = $statement->fetchAll(PDO::FETCH_ASSOC);

        if($existUser){
            $errors[] = "Username or password has already exist.";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $statementAdd = $pdo->prepare("INSERT INTO user (username, email, password) 
                                VALUES (:username, :email, :password)");
            $statementAdd->bindValue(":username", $username);
            $statementAdd->bindValue(":email", $email);
            $statementAdd->bindValue(":password", $passwordHash);
            $statementAdd->execute();
            header("Location: login.php");
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
<div class="container">
    <div class="left">
        <div class="content">
            <div class="auth-logo">
                <a href="https://base.vn">
                    <img src="https://share-gcdn.basecdn.net/brand/logo.full.png"/>
                </a>
            </div>
            <div class="title">
                <h1>Đăng ký</h1>
                <span>Chào mừng bạn. Đăng ký để bắt đầu làm việc.</span>
            </div>
            <div class="box">
                <form method="post" id="signupForm">
                    <div class="row">
                        <div class="label">Username</div>
                        <div class="input">
                            <input
                                type="text"
                                name="username"
                                placeholder="Username của bạn"
                                required=""
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="label">Email</div>
                        <div class="input">
                            <input
                                type="email"
                                name="email"
                                placeholder="Email của bạn"
                                required=""
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="label">Mật khẩu</div>
                        <div class="input">
                            <input
                                type="password"
                                name="password"
                                placeholder="Mật khẩu của bạn"
                            />
                        </div>
                    </div>
                </form>
                <div class="form-relative">
                    <button class="submit" form="signupForm">
                        Đăng ký
                    </button>
                    <div class="already">Đã có tài khoản?
                        <span id="login">Đăng nhập</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right">
    </div>
</div>
    <?php require_once 'popup.php'; ?>

    var redirectLogin = document.getElementById("login");
    redirectLogin.addEventListener("click", () => {
        window.location.href = "login.php";
    });
</script>
</html>