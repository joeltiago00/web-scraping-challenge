<?php

namespace App\Repositories;

use App\Exceptions\Product\FailToFindProductException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductNotStoredException;
use App\Exceptions\Product\ProductNotUpdatedException;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Product::class);
    }

    /**
     * @param array $data
     * @return Product
     * @throws ProductNotStoredException
     */
    public function store(array $data): Product
    {
        try {
            return $this->getModel()::create($data);
        } catch (\Exception $exception) {
            throw new ProductNotStoredException($exception);
        }
    }

    /**
     * @param Product $product
     * @param array $data
     * @return bool
     * @throws ProductNotUpdatedException
     */
    public function update(Product $product, array $data): bool
    {
        try {
            return $product->update($data);
        } catch (\Exception $exception) {
            throw new ProductNotUpdatedException($exception);
        }
    }

    /**
     * @param string $code
     * @return bool
     * @throws FailToFindProductException
     * @throws ProductNotFoundException
     */
    public function existsByCode(string $code): bool
    {
        try {
            $product = $this->getModel()::where('code', $code)->first();
        } catch (\Exception $exception) {
            throw new FailToFindProductException($exception);
        }

        return !empty($product);
    }

    /**
     * @param string $code
     * @return Product
     * @throws FailToFindProductException
     * @throws ProductNotFoundException
     */
    public function getByCode(string $code): Product
    {
        try {
            $product = $this->getModel()::where('code', $code)->first();
        } catch (\Exception $exception) {
            throw new FailToFindProductException($exception);
        }

        if (empty($product))
            throw new ProductNotFoundException();

        return $product;
    }

    public function getProducts(int $skip, int $perPage): Collection
    {
        return $this->getModel()::skip($skip)->take($perPage)->get();
    }
}
