<?php

namespace App\Core;

use JetBrains\PhpStorm\Pure;

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

    #[Pure] public function __construct()
    {
        $this->request = new Request;
        $this->router = new Router($this->request);
    }

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->router->resolve();
    }
}