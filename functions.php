<?php
function randomString($n)
{
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