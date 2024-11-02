<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
               \App\Http\Middleware\ForceHttps::class, // voeg deze regel toe
        // andere middleware...
    ];

    // Rest van de Kernel klasse...
}
