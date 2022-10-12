<?php

namespace App\Exceptions\Scraping;

use App\Services\Logging\Facades\Logging;
use Illuminate\Http\Response;

class FailToMakeScrapingException extends ScrapingException
{
    public function __construct(\Throwable $throwable)
    {
        parent::__construct(
            trans('exceptions.scraping.fail', ['error_code' => Logging::critical($throwable)]),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
