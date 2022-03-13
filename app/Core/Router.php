<?php

namespace App\Core;

use Exception;

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
     * @var Response $response
     */
    protected Response $response;

    /**
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function get(string $path, mixed $callback): void
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
     * @return string
     * @throws Exception
     */
    public function resolve(): string
    {
        try {
            $path = $this->request->getPath();
            $method = $this->request->getMethod();

            $args = [$this->request->resolveId()];

            $callback = $this->routes[$method][$path] ?? false;

            if (!$callback) {
                $this->response->setStatusCode(404);
                return 'Not found';
            }

            if (is_array($callback)) {
                $callback[0] = new $callback[0];
            }

            return call_user_func_array($callback, $args);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}