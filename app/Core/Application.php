<?php

namespace App\Core;

use JetBrains\PhpStorm\Pure;
use Exception;

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

    /**
     * @var Response $response
     */
    public Response $response;

    #[Pure] public function __construct()
    {
        $this->request  = new Request;
        $this->response = new Response;
        $this->router   = new Router($this->request, $this->response);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        return $this->router->resolve();
    }
}