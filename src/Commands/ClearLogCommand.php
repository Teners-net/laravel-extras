<?php

namespace Teners\LaravelExtras\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ClearLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'log:clear';

    /**
     * The console command description.
     */
    protected $description = 'Clear log data';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        exec('rm -f ' . storage_path('logs/*.log'));

        Log::info("Logs Cleared at " . date('l jS \of F Y h:i:s A'));
        $this->info("Logs cleared!");

        return $this::SUCCESS;
    }
}
