<?php

namespace App\Exceptions\Product;

use App\Services\Logging\Facades\Logging;
use Illuminate\Http\Response;

class ProductNotUpdatedException extends ProductException
{
    public function __construct(\Throwable $throwable)
    {
        parent::__construct(
            trans('exceptions.product.not-updated', ['error_code' => Logging::critical($throwable)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
