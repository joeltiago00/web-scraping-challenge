<?php

namespace App\Types;

enum ProductStatus: string {
    case DRAFT = 'draft';
    case IMPORTED = 'imported';
}
