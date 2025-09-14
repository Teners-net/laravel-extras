<?php

namespace Teners\LaravelExtras\Commands;

use Exception;
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
    protected $description = 'Clear log files content';

    public function handle(): int
    {
        $logPath = storage_path('logs');

        if (!is_dir($logPath)) {
            $this->error('Log directory does not exist.');
            return Command::FAILURE;
        }

        $logFiles = glob($logPath . '/*.log');
        $clearedFiles = 0;

        foreach ($logFiles as $file) {
            if ($this->clearLogFile($file)) {
                $clearedFiles++;
            }
        }

        $this->info("Cleared {$clearedFiles} log files!");
        return Command::SUCCESS;
    }

    /**
     * Clear the log file.
     */
    private function clearLogFile(string $file): bool
    {
        try {
            return file_put_contents($file, "Logs cleared at " . now()->toDateTimeString() . PHP_EOL) !== false;
        } catch (Exception $e) {
            $this->error("Failed to clear {$file}: {$e->getMessage()}");
            return false;
        }
    }
}
