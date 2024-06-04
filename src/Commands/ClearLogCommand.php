<?php

namespace Teners\LaravelExtras\Commands;

use Illuminate\Console\Command;

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
        $logFiles = glob(storage_path('logs/*.log'));

        foreach ($logFiles as $file) {
            $handle = fopen($file, 'w');

            if ($handle) {
                fwrite($handle, "Logs Cleared at " . date('l jS \of F Y h:i:s A'));
                fclose($handle);
            } else {
                $this->error("Failed to open '$file' for writing.");
            }
        }

        $this->info("Logs cleared!");

        return Command::SUCCESS;
    }
}
