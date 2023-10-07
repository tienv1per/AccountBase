<?php
function randomString($n): string {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }

    return $str;
}

function getEnvVar($varName, $defaultValue = null) {
    $envContent = file_get_contents('.env');
    $lines = explode("\n", $envContent);

    foreach ($lines as $line) {
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        if ($key === $varName) {
            return $value;
        }
    }
    return $defaultValue;
}

function setCookies(int $id, string $email): void {
    session_start();
    $_SESSION ['id'] = $id;
    $_SESSION['email'] = $email;
    setcookie(session_name(), $_COOKIE[session_name()], time() + 24 * 60 * 60 * 7);
}

function saveImages($image): string {
    if(!is_dir('images')) {
        mkdir('images');
    }
    if($_FILES['image']['name']){
        $imagePath = 'images/' . randomString(8) . '/' . $_FILES['image']['name'];
        mkdir(dirname($imagePath));
    } else {
        $imagePath = $image;
    }
    if($imagePath) {
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    return $imagePath;
}
