<?php
require_once __DIR__ . '/../vendor/autoload.php';
use app\core\Application;

$app = new Application(dirname(__DIR__));

$app->router->get('/', '/home');

$app->router->get('/contact', 'contact');

$app->router->get('/login', function (){
    return "Login Page";
});

$app->run();