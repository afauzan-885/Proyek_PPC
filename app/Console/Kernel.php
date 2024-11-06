<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Support\Facades\App;

class kernel extends HttpKernel
{
    // app/Http/Kernel.php
    protected $routeMiddleware = [
        'CekStatusAktif' => \App\Http\Middleware\CekStatusAktif::class,
    ];

    protected $commands = [
        \App\Console\Commands\ResetRequestStatus::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('reset:request-status')->everyMinute();
    }
}
