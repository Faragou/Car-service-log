<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * A list of global HTTP middleware that should be run for every request.
     *
     * @var array
     */
    use Fruitcake\Cors\HandleCors;

    protected $middleware = [
        // Add this line
        \Fruitcake\Cors\HandleCors::class,
    ];


    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // Más middleware-ek
        ],

        'api' => [
            // Más API middleware-ek
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Más útvonalhoz rendelt middleware-ek
    ];
}
