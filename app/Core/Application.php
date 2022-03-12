<?php

namespace App\Core;

class Application
{
    /**
     * @var Router $router
     */
    public Router $router;

    /**
     * @var Request $request
     */
    public Request $request;

    public function __construct()
    {
        $this->request = new Request;
        $this->router = new Router($this->request);
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $this->router->resolve();
    }
}