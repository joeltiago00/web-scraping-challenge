<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\ProductRequest;
use App\Services\Product\ProductService;
use App\Transformers\ProductTransformer;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private ProductService $productService;
    /**
     * @var ProductTransformer
     */
    private ProductTransformer $productTransformer;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->productTransformer = new ProductTransformer();
    }

    /**
     * @param string $code
     * @return JsonResponse
     */
    public function show(string $code): JsonResponse
    {
        $product = $this->productService->getByCode($code);

        return ResponseHelper::results($this->productTransformer->show($product));
    }

    /**
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function index(ProductRequest $request): JsonResponse
    {
        $pp = $request->pp;
        $pg = $request->pg;

        $products = $this->productService->getProducts($pp, $pg);

        return ResponseHelper::results(
            [
                'pagination' => [
                    'page' => $pg,
                    'per_page' => $pp,
                ],
                'products' => $this->productTransformer->index($products)
            ]);
    }
}
