<?php

namespace App\Core;

class Router
{
    /**
     * @var array $routes
     */
    protected array $routes = [];

    /**
     * @var Request $request
     */
    protected Request $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $path
     * @param callable $callback
     * @return void
     */
    public function get(string $path, callable $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * @param string $path
     * @param callable $callback
     * @return void
     */
    public function post(string $path, callable $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @return void
     */
    public function resolve(): void
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $args = $method === 'GET' ? $_GET : $_POST;
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            echo 'Not found';
            exit;
        }

        echo $callback($args);
    }
}