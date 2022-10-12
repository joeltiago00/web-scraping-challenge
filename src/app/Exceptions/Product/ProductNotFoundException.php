<?php

namespace App\Exceptions\Product;

use Illuminate\Http\Response;

class ProductNotFoundException extends ProductException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.product.not-found'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
