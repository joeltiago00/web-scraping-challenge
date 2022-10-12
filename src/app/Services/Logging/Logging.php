<?php

namespace App\Services\Logging;

use App\Exceptions\Logging\LoggingNotCreated;
use App\Types\LogLevel;
use Illuminate\Support\Str;
use Throwable;

class Logging
{
    /**
     * @param Throwable $e
     * @return string
     * @throws LoggingNotCreated
     */
    public function critical(Throwable $e): string
    {
        $log = new \App\Models\Logging();

        try {
            $log->fill([
                'code' => Str::uuid()->toString(),
                'level' => LogLevel::CRITICAL->value,
                'message' => $e->getMessage(),
                'trace' => json_encode($e->getTraceAsString()),
                'error_code' => $e->getCode()
            ])->save();
        } catch (\Exception $exception) {
            throw new LoggingNotCreated($exception);
        }

        return $log->code;
    }
}
