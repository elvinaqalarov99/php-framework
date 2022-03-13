<?php

namespace App\Core;

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
}