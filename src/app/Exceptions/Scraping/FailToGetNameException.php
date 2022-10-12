<?php

namespace App\Exceptions\Scraping;

use Illuminate\Http\Response;

class FailToGetNameException extends ScrapingException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.scraping.fail-get-name'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
