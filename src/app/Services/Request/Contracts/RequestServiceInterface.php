<?php

namespace App\Services\Request\Contracts;

interface RequestServiceInterface
{
    public function get(string $url): RequestResponseInterface;

    public function post(string $url, array $data = []): RequestResponseInterface;

    public function patch(string $url, array $data = []): RequestResponseInterface;

    public function put(string $url, array $data = []): RequestResponseInterface;

    public function delete(string $url, array $data = []): RequestResponseInterface;

}
