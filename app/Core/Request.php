<?php

namespace App\Core;

use JetBrains\PhpStorm\Pure;

class Request
{
    /**
     * @return false|mixed|string
     */
    public function getPath(): mixed
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = str_ends_with($uri, '/') && strlen($uri) > 1 ? rtrim($uri, '/') : $uri;

        $position = strpos($path, '?');

        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
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
     * @param $key
     * @return array|null
     */
    #[Pure] public function all($key): array|null
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