<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ResetRequestStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:request-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset reset_request_status to null if expired';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::where('reset_request_expiry', '<', now())
            ->update(['reset_request_status' => null, 'reset_request_expiry' => null]);

        $this->info('Request Password telah diatur ulang!');
    }
}