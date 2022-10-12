<?php

namespace App\Services\Request;

use App\Exceptions\Request\RequestClientException;
use App\Exceptions\Request\RequestServerException;
use App\Services\Request\Contracts\RequestResponseInterface;
use App\Services\Request\Contracts\RequestServiceInterface;
use App\Types\RequestMethod;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

class RequestService implements RequestServiceInterface
{
    /**
     * @var Client
     */
    private readonly Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $url
     * @return RequestResponseInterface
     * @throws GuzzleException
     * @throws RequestClientException
     * @throws RequestServerException
     */
    public function get(string $url): RequestResponseInterface
    {
        return $this->makeRequest($url, RequestMethod::GET->value);
    }

    /**
     * @param string $url
     * @param array $data
     * @return RequestResponseInterface
     * @throws GuzzleException
     * @throws RequestClientException
     * @throws RequestServerException
     */
    public function post(string $url, array $data = []): RequestResponseInterface
    {
        return $this->makeRequest($url, RequestMethod::POST->value);
    }

    /**
     * @param string $url
     * @param array $data
     * @return RequestResponseInterface
     * @throws GuzzleException
     * @throws RequestClientException
     * @throws RequestServerException
     */
    public function patch(string $url, array $data = []): RequestResponseInterface
    {
        return $this->makeRequest($url, RequestMethod::PATCH->value);
    }

    /**
     * @param string $url
     * @param array $data
     * @return RequestResponseInterface
     * @throws GuzzleException
     * @throws RequestClientException
     * @throws RequestServerException
     */
    public function put(string $url, array $data = []): RequestResponseInterface
    {
        return $this->makeRequest($url, RequestMethod::PUT->value);
    }

    /**
     * @param string $url
     * @param array $data
     * @return RequestResponseInterface
     * @throws GuzzleException
     * @throws RequestClientException
     * @throws RequestServerException
     */
    public function delete(string $url, array $data = []): RequestResponseInterface
    {
        return $this->makeRequest($url, RequestMethod::DELETE->value);
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $data
     * @return RequestResponse
     * @throws GuzzleException
     * @throws RequestClientException
     * @throws RequestServerException
     */
    private function makeRequest(string $url, string $method, array $data = []): RequestResponse
    {
        try {
            $response = $this->client->request($method, $url, $data);
        } catch (ClientException $exception) {
            throw new RequestClientException($exception);
        } catch (ServerException $exception) {
            throw new RequestServerException($exception);
        }

        return new RequestResponse($response);
    }
}
