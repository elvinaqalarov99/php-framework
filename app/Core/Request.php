<?php

namespace App\Core;

use JetBrains\PhpStorm\Pure;

class Request
{
    /**
     * @return string
     */
    public function getPath(): string
    {
        $uri = $this->parseUrl();

        $id = isset($uri[3]) ? '{id}' : '';

        $path = '/' . ($uri[1] === 'api' ? $uri[1] . (isset($uri[2]) ? "/$uri[2]" : '') : $uri[1]);

        if (!empty($id)) {
            $path .= "/$id";
        }

        return $path;
    }

    /**
     * @return string
     */
    #[Pure] public function resolveId(): string
    {
        $uri = $this->parseUrl();

        return isset($uri[3]) ? (int) $uri[3] : 0;
    }

    /**
     * @return array
     */
    public function parseUrl(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        return explode('/', $uri);
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @param array $data
     * @return void
     */
    public function sanitizeRequest(array &$data): void
    {
        $type = $this->getMethod() === 'get' ? INPUT_GET : INPUT_POST;

        foreach ($data as $key => $value) {
            $data[$key] = filter_input($type, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }

    /**
     * @return array
     */
    #[Pure] protected function getData(): array
    {
        $data =  $this->getMethod() === 'get' ? $_GET : $_POST;

        $this->sanitizeRequest($data);

        return $data;
    }

    /**
     * @return array|null
     */
    #[Pure] public function all(): array|null
    {
        return $this->getData();
    }

    /**
     * @param $key
     * @return mixed
     */
    #[Pure] public function get($key): mixed
    {
        if (empty($key)) {
            return $this->getData();
        }

        return $this->getData()[$key] ?? null;
    }
}