<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Database $database;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->database = new Database();
        $this->router = new Router($this->request, $this->database);
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }
}