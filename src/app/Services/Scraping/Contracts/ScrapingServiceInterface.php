<?php

namespace App\Services\Scraping\Contracts;

interface ScrapingServiceInterface
{
    public function search(string $url, string $filter): array;
}
