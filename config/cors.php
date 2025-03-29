<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Minden HTTP metódus engedélyezése (pl. GET, POST, PUT, DELETE)

    'allowed_origins' => ['*'], // Minden origin engedélyezése (pl. http://localhost:8080)

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Minden header engedélyezése

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];

