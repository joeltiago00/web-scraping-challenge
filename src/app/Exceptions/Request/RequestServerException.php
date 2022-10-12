<?php

namespace App\Exceptions\Request;

use App\Services\Logging\Facades\Logging;
use Illuminate\Http\Response;

class RequestServerException extends RequestException
{
    public function __construct(\Throwable $throwable)
    {
        parent::__construct(
            trans('exceptions.request.server-error', ['error_code' => Logging::critical($throwable)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
