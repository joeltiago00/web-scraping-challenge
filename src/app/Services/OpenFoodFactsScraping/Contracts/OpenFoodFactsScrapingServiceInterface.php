<?php

namespace App\Services\OpenFoodFactsScraping\Contracts;

interface OpenFoodFactsScrapingServiceInterface
{
    public function getProductsLinks(): array;

    public function getProductInfo(string $uri): OpenFoodFactsProductInterface;
}
