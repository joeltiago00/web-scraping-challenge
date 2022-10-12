<?php

namespace App\Transformers;

use App\Core\Product\Contracts\ProductInterface;
use App\Core\Product\Product;

class ProductTransformer
{
    /**
     * @param ProductInterface $product
     * @return array
     */
    public function show(ProductInterface $product): array
    {
        return $product->toArray();
    }

    /**
     * @param Product[] $products
     * @return array
     */
    public function index(array $products): array
    {
        foreach ($products as $product) {
            $response[] = $product->toArray();
        }

        return $response ?? [];
    }
}
