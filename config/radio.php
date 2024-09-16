<?php

return [
    'liquidsoap' => [

    ],
    'icecast' => [
        'port' => env('ICECAST_PORT', 8004),
        'password' => env('ICECAST_ADMIN_PASSWORD', 'hackme'),
    ]
];