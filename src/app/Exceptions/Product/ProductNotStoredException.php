<?php

namespace App\Exceptions\Product;

use App\Services\Logging\Facades\Logging;
use Illuminate\Http\Response;

class ProductNotStoredException extends ProductException
{
    public function __construct(\Throwable $throwable)
    {
        parent::__construct(
            trans('exceptions.product.not-stored', ['error_code' => Logging::critical($throwable)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
