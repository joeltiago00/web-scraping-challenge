<?php

namespace App\Exceptions\Scraping;

use Illuminate\Http\Response;

class FailToGetCodeException extends ScrapingException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.scraping.fail-get-code'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
