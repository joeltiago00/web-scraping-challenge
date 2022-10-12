<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Logging extends Model
{
    use SoftDeletes;

    protected $collection = 'logging';

    protected $fillable = [
        'code', 'level', 'message', 'trace', 'error_code'
    ];
}
