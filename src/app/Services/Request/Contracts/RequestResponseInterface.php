<?php

namespace App\Services\Request\Contracts;

interface RequestResponseInterface
{
    public function getStatusCode(): int;

    public function getBody(): array;

    public function getHTML(): string;
}
