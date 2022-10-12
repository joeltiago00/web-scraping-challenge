<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $collection = 'products';

    protected $fillable = [
        'code', 'barcode', 'url', 'status', 'imported_t', 'product_name', 'quantity', 'categories', 'packaging',
        'brands', 'image_url', 'name'
    ];
}
