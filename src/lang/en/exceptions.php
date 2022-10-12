<?php

return [
    'logging' => [
        'not-created' => 'Error during logging. Error code: :error_code.',
    ],

    'product' => [
        'fail-find-by-code' => 'Fail to find product. Error code :error_code.',
        'not-found' => 'Product not found.',
        'not-stored' => 'Product not stored. Error code: :error_code.',
        'not-updated' => 'Product not updated. Error code: :error_code.',
    ],

    'request' => [
        'client-error' => 'Client error during request. Error code :error_code.',
        'server-error' => 'Server error during request. Error code :error_code.',
    ],

    'scraping' => [
        'fail-get-barcode' => 'Fail to get barcode.',
        'fail-get-categories' => 'Fail to get categories',
        'fail-get-code' => 'Fail to get code.',
        'fail-get-name' => 'Fail to get name.',
        'fail' => 'Fail during scraping. Error code: :error_code.',
    ],
];
