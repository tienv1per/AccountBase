<?php
session_start();
//echo '<pre>';
//var_dump($_SESSION);
//echo '</pre>';
unset($_SESSION['user_email']);
unset($_SESSION['user_id']);
header("Location: login.php");
?>

