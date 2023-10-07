<?php

namespace app\core;

class Router {
    protected array $routes = [
        'get' => [],
        'post' => []
    ];
    public Request $request;
    public Database $database;

    public function __construct(Request $request, Database $database) {
        $this->request = $request;
        $this->database = $database;
    }

    public function get($path, $callback): void {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback): void {
        $this->routes['post'][$path] = $callback;
    }

    public function renderView($view, $params=[]): bool|string {
        ob_start();
        include_once __DIR__."/../views/$view.php";
        return ob_get_clean();
    }

    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false){
            echo "Not found";
            exit;
        }

        // this is view file
        if(is_string($callback)){
            return $this->renderView($callback);
        }
        return call_user_func($callback, $this);
    }
}
