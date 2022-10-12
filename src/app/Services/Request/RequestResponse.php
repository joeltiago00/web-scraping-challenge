<?php

namespace App\Services\Request;

use App\Services\Request\Contracts\RequestResponseInterface;
use GuzzleHttp\Psr7\Response;

class RequestResponse implements RequestResponseInterface
{
    /**
     * @param Response $response
     */
    public function __construct(
        private readonly Response $response
    ) { }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return json_decode($this->response->getBody(), true) ?? [];
    }

    /**
     * @return string
     */
    public function getHTML(): string
    {
        return $this->response->getBody()->getContents();
    }
}
