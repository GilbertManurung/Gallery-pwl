<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    */
    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    */
    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        // ===== MINIO BUCKET: SPORT =====
        'sport' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'bucket' => 'sport',
            'url' => env('AWS_URL') . '/sport', // PENTING: tambahkan bucket name
            'endpoint' => env('AWS_ENDPOINT'), // http://minio:9000 (internal Docker)
            'use_path_style_endpoint' => true,
            'visibility' => 'public',
            'throw' => true,
        ],

        // ===== MINIO BUCKET: AESTHETIC =====
        'aesthetic' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'bucket' => 'aesthetic',
            'url' => env('AWS_URL') . '/aesthetic', // PENTING: tambahkan bucket name
            'endpoint' => env('AWS_ENDPOINT'), // http://minio:9000 (internal Docker)
            'use_path_style_endpoint' => true,
            'visibility' => 'public',
            'throw' => true,
        ],
    ],
];