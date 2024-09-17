<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class kernel extends HttpKernel
{
    // app/Http/Kernel.php
    protected $routeMiddleware = [
        'CekStatusAktif' => \App\Http\Middleware\CekStatusAktif::class
    ];
}
