<?php

namespace App\Services\Product;

use App\Core\Product\Contracts\ProductInterface;
use App\Exceptions\Product\FailToFindProductException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Product\ProductNotStoredException;
use App\Exceptions\Product\ProductNotUpdatedException;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\OpenFoodFactsScraping\Contracts\OpenFoodFactsProductInterface;
use App\Types\ProductStatus;
use Carbon\Carbon;
use MongoDB\BSON\UTCDateTime;

class ProductService
{
    /**
     * @var ProductRepository
     */
    private ProductRepository $repository;

    public function __construct()
    {
        $this->repository = new ProductRepository();
    }

    /**
     * @param OpenFoodFactsProductInterface $product
     * @return Product
     * @throws ProductNotStoredException
     */
    public function store(OpenFoodFactsProductInterface $product): Product
    {
        return $this->repository->store(
            array_merge(
                $product->toArray(),
                ['imported_t' => new UTCDateTime(Carbon::now()), 'status' => ProductStatus::IMPORTED->value]
            )
        );
    }

    /**
     * @param OpenFoodFactsProductInterface $product
     * @return bool
     * @throws FailToFindProductException
     * @throws ProductNotFoundException
     * @throws ProductNotUpdatedException
     */
    public function update(OpenFoodFactsProductInterface $product): bool
    {
        $product_model = $this->repository->getByCode($product->getCode());

        return $this->repository->update($product_model, $product->toArray());
    }

    public function getByCode(string $code): ProductInterface
    {
        $product = $this->repository->getByCode($code);

        return new \App\Core\Product\Product(
            $product->_id, $product->code, $product->barcode, $product->url, $product->name, $product->quantity,
            $product->categories, $product->packaging, $product->brands, $product->image_url, $product->imported_t,
            $product->status
        );
    }

    /**
     * @param int $perPage
     * @param int $page
     * @return \App\Core\Product\Product[]
     */
    public function getProducts(int $perPage, int $page): array
    {
        $skip = $page === 1 ? 0 :($page - 1) * $perPage;

        $products = $this->repository->getProducts($skip, $perPage);

        /**
         * @var Product
         */
        foreach ($products as $product) {
            $prods[] = new \App\Core\Product\Product(
                $product->_id, $product->code, $product->barcode, $product->url, $product->name, $product->quantity,
                $product->categories, $product->packaging, $product->brands, $product->image_url, $product->imported_t,
                $product->status
            );
        }

        return $prods ?? [];
    }

    /**
     * @param string $code
     * @return bool
     * @throws FailToFindProductException
     * @throws ProductNotFoundException
     */
    public function existsByCode(string $code): bool
    {
        return $this->repository->existsByCode($code);
    }
}
