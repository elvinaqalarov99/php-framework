<?php

declare(strict_types=1);

namespace App\Services\Http;

use GuzzleHttp\{Client, Exception\GuzzleException};
use App\Models\Activity;
use Exception;

class BaseService implements IBaseService
{
    /**
     * @var Client $client
     */
    protected Client $client;

    /**
     * @var string $method
     */
    protected string $method = 'GET';

    /**
     * @var string $url
     */
    protected string $url = '';

    /**
     * @var array $options
     */
    protected array $options = [
        'debug' => false,
        'query' => []
    ];


    public function __construct()
    {
        $this->client = new Client;
    }

    /**
     * @param string $method
     * @return BaseService
     */
    public function method(string $method): BaseService
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function url(string $url): BaseService
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function query(array $query): BaseService
    {
        $this->options['query'] = array_merge($query, $this->options['query']);

        return $this;
    }

    /**
     * @return $this
     */
    public function withDebug(): BaseService
    {
        $this->options['debug'] = true;

        return $this;
    }

    /**
     * @return string
     */
    public function send(): string
    {
        try {
            echo "Loading your response...\n";

            $request = $this->client->request($this->method, $this->url, $this->options);

            $response = $request->getBody()->getContents();
            $responseArray = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

            (new Activity)->insert($responseArray);

            return $response;
        } catch (GuzzleException|Exception $exception) {
            return $exception->getMessage();
        }
    }
}