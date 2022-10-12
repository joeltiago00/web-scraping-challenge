<?php

namespace App\Services\OpenFoodFactsScraping\Contracts;

interface OpenFoodFactsProductInterface
{
    public function getCode(): string;

    public function getBarcode(): string;

    public function getUrl(): string;

    public function getName(): string;

    public function getQuantity(): string;

    public function getCategories(): string;

    public function getPackaging(): string;

    public function getBrads(): string;

    public function getImageUrl(): string;

    public function toArray(): array;
}
