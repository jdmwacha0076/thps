<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'session.timeout' => \App\Http\Middleware\SessionTimeout::class,
    ];
}
