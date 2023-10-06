<?php

namespace app\core;

class Router
{
    protected array $routes = [
        'get' => [],
        'post' => []
    ];
    public Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function renderView($view)
    {
        ob_start();
        include_once __DIR__."/../views/$view.php";
        return ob_get_clean();
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;
        //echo $callback.'<br>';
        if($callback === false){
            echo "Not found";
            exit;
        }

        // this is view file
        if(is_string($callback)){
//            echo '<pre>';
//            var_dump($callback);
//            echo '</pre>';
            return $this->renderView($callback);
        }
        echo call_user_func($callback, $this);
    }
}