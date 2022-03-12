<?php

namespace App\Services\Http;

interface IBaseService
{
    /**
     * @param string $method
     * @return BaseService
     */
    public function method(string $method): BaseService;

    /**
     * @param string $url
     * @return BaseService
     */
    public function url(string $url): BaseService;

    /**
     * @param array $query
     * @return BaseService
     */
    public function query(array $query): BaseService;

    /**
     * @return BaseService
     */
    public function withDebug(): BaseService;

    /**
     * @return string
     */
    public function send(): string;
}