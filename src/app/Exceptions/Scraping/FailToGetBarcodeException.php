<?php

namespace App\Exceptions\Scraping;

use App\Services\Logging\Facades\Logging;
use Illuminate\Http\Response;

class FailToGetBarcodeException extends ScrapingException
{
    public function __construct()
    {
        parent::__construct(
            trans('exceptions.scraping.fail-get-barcode'),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
