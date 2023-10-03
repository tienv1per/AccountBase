<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=base', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Invalid email ''. Please try again.";
    }
    if(!$password){
        $errors[] = 'Mật khẩu không hợp lệ. Vui lòng thử lại.';
    }

    if(empty($errors)){
        $statement = $pdo->prepare("SELECT * FROM user WHERE email = :email");
        $statement->bindValue(":email", $email);
        $statement->execute();
        $user = $statement->fetchAll(PDO::FETCH_ASSOC);

        if($user) {
            $passwordUser = $user[0]['password'];
            if(password_verify($password, $passwordUser)){
                header("Location: account.php");
            } else {
                $errors[] = "Email or password not correct";
            }
        }
        else {
            $errors[] = "Email or password not correct";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Base</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="popup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                <h1>Đăng nhập</h1>
                <span>Chào mừng trở lại. Đăng nhập để bắt đầu làm việc.</span>
            </div>
            <div class="box">
                <form method="post" id="loginForm">
                    <div class="row">
                        <div class="label">Email</div>
                        <div class="input">
                            <input
                                type="text"
                                name="email"
                                placeholder="Email của bạn"
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
                    <div class="checkbox">
                        <input
                            type="checkbox"
                            checked
                            name="saved"
                        />
                        &nbsp; Giữ tôi luôn đăng nhập
                    </div>
                    <button class="submit" type="submit" form="loginForm">
                        Đăng nhập để bắt đầu làm việc
                    </button>
                    <div class="oauth">
                        <div class="label">
                            <span>Hoặc, đăng nhập thông qua SSO</span>
                        </div>
                        <a class="oauth-login left24k" href="https://sso.base.vn/google">Đăng nhập bằng Google</a>
                        <a class="oauth-login right24k" href="https://sso.base.vn/ms">Đăng nhập bằng Microsoft</a>
                        <a class="oauth-login left24k" href="https://sso.base.vn/apple">Đăng nhập bằng AppleID</a>
                        <div class="oauth-login right24k">Đăng nhập bằng SAML</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="right">
    </div>
</div>
<?php  require_once 'popup.php'; ?>
</script>
</html>