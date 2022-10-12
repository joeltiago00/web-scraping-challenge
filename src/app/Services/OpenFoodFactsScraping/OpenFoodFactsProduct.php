<?php

namespace App\Services\OpenFoodFactsScraping;

use App\Services\OpenFoodFactsScraping\Contracts\OpenFoodFactsProductInterface;

class OpenFoodFactsProduct implements OpenFoodFactsProductInterface
{
    /**
     * @param string $code
     * @param string $barcode
     * @param string $url
     * @param string $name
     * @param string $quantity
     * @param string $categories
     * @param string $packaging
     * @param string $brands
     * @param string $imageUrl
     */
    public function __construct(
        private readonly string $code,
        private readonly string $barcode,
        private readonly string $url,
        private readonly string $name,
        private readonly string $quantity,
        private readonly string $categories,
        private readonly string $packaging,
        private readonly string $brands,
        private readonly string $imageUrl,
    ) { }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getQuantity(): string
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getCategories(): string
    {
        return $this->categories;
    }

    /**
     * @return string
     */
    public function getPackaging(): string
    {
        return $this->packaging;
    }

    /**
     * @return string
     */
    public function getBrads(): string
    {
        return $this->brands;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'barcode' => $this->barcode,
            'url' => $this->url,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'categories' => $this->categories,
            'packaging' => $this->packaging,
            'brands' => $this->brands,
            'image_url' => $this->imageUrl
        ];
    }
}
