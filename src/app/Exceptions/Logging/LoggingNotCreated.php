<?php

namespace App\Exceptions\Logging;

use Illuminate\Http\Response;

class LoggingNotCreated extends LoggingException
{
    public function __construct(\Throwable $e)
    {
        parent::__construct(
            trans('exceptions.logging.not-created', ['error' => $e->getMessage()]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
