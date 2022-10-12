<?php

namespace App\Types;

enum RequestMethod: string {
    case GET = 'get';
    case POST = 'post';
    case PATCH = 'patch';
    case PUT = 'put';
    case DELETE = 'delete';
}
