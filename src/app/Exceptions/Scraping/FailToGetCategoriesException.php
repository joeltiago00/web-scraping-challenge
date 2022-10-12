<?php

namespace App\Exceptions\Scraping;

use Illuminate\Http\Response;

class FailToGetCategoriesException extends ScrapingException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.scraping.fail-get-categories'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
