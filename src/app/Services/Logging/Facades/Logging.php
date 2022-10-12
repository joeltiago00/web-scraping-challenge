<?php

namespace App\Services\Logging\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static critical(\Throwable $e)
 * @method static info(string $message)
 * @method static fail(string $message)
 *
 * @see \App\Services\Logging\Logging
 */
class Logging extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LOGGING';
    }
}
