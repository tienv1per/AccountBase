<?php
require_once __DIR__ . '/../vendor/autoload.php';
use app\core\Application;
use app\controllers\UserController;

$app = new Application(dirname(__DIR__));

$app->router->get('/', '/home');

$app->router->get('/contact', 'contact');

$app->router->get('/login', [new UserController(), 'login']);
$app->router->post('/login', [new UserController(), 'login']);

$app->router->get('/logout', [new UserController(), 'logout']);

$app->router->get('/signup', [new UserController(), 'signup']);
$app->router->post('/signup', [new UserController(), 'signup']);

$app->router->get('/account', [new UserController(), 'account']);
$app->router->post('/account', [new UserController(), 'account']);

$app->router->post('/update', [new UserController(), 'update']);

$app->run();