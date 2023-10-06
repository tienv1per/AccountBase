<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Base</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/popup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                    <div class="g-recaptcha" data-sitekey="6Ld0oXUoAAAAADMHAjYB_d5o5Ly9GqDhTMtKWnJs"></div>
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
                    <!--                    <form method="post" id="captchaForm">-->
                    <!---->
                    <!--                    </form>-->
                    <button class="submit" type="submit" form="loginForm" name="submit">
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