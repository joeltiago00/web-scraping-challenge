<?php

namespace App\Core\Product;

use App\Core\Product\Contracts\ProductInterface;

class Product implements ProductInterface
{
    /**
     * @param string $id
     * @param string $code
     * @param string $barcode
     * @param string $url
     * @param string $name
     * @param ?string $quantity
     * @param string $categories
     * @param ?string $packaging
     * @param string $brands
     * @param ?string $imageUrl
     * @param string $importedT
     * @param string $status
     */
    public function __construct(
        private readonly string $id,
        private readonly string $code,
        private readonly string $barcode,
        private readonly string $url,
        private readonly string $name,
        private readonly ?string $quantity,
        private readonly string $categories,
        private readonly ?string $packaging,
        private readonly string $brands,
        private readonly ?string $imageUrl,
        private readonly string $importedT,
        private readonly string $status
    ) { }

    /**
     * @return string
     */
    public function getID(): string
    {
        return $this->id;
    }

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
        return $this->quantity ?? '0';
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
        return $this->packaging ?? '';
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
        return $this->imageUrl ?? '';
    }

    /**
     * @return string
     */
    public function getImportedT(): string
    {
        return $this->importedT;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            '_id' => $this->id,
            'code' => $this->code,
            'barcode' => $this->barcode,
            'url' => $this->url,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'categories' => $this->categories,
            'packaging' => $this->packaging,
            'brands' => $this->brands,
            'image_url' => $this->imageUrl,
            'status' => $this->status,
            'imported_t' => $this->importedT,
        ];
    }
}
