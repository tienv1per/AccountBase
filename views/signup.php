<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Base</title>
    <link rel="stylesheet" href="../css/signup.css">
    <link rel="stylesheet" href="../css/popup.css">
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
window.location.href = "login";
});
</script>
</html>