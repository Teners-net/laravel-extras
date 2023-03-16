<?php

namespace Platinum\LaravelExtras\Commands;

use Illuminate\Support\Str;
use Platinum\LaravelExtras\Helpers\CommandGenerator;
use Platinum\LaravelExtras\Helpers\FileGenerator;
use Platinum\LaravelExtras\Helpers\GenerateFileContent;

class MakeBladeCommand extends CommandGenerator
{
    public $argumentName = 'view';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:blade 
      {view : The name of the blade view}
      {--b|base : Use html5 template}
      {--force : Override the view even if it already exists}';

    
    protected function stubPath(): string
    {
      $stub = $this->option('base') ? 'blade-base.stub' : 'blade.stub';

      return __DIR__ . '/../stubs/' . $stub;
    }

    /**
     * The console command description.
     */
    protected $description = 'Create a new blade view';

    /**
     * Get the blade name in camel case
     */
    private function getBladeViewName(): string
    {
        return Str::camel($this->argument('view'));
    }

    /**
     * getDestinationFilePath
     *
     * @return string
     */
    protected function getDestinationFilePath(): string
    {
        return base_path().'/resources/views/'. $this->getBladeViewName() . '.blade.php';
    }

    /**
     * Get Template Content
     */
    protected function getTemplateContent(): string
    {
        return (
            new GenerateFileContent
            (
                $this->stubPath(),
            )
        )->generateContent();
    }

    /**
     * Execute the console command
     */
    public function handle()
    {
        $path = str_replace('\\', '/', $this->getDestinationFilePath());

        if (!$this->laravel['files']->isDirectory($dir = dirname($path)))
        {
            $this->laravel['files']->makeDirectory($dir, 0777, true);
        }

        $contents = $this->getTemplateContent();

        try {
            (new FileGenerator($path, $contents, $this->useOveride()))->generateFile();
            
            $this->info("Created blade: {$path}");
        } catch (\Exception $e) {

            $this->error("File : {$e->getMessage()}");

            return E_ERROR;
        }

        return $this::SUCCESS;
    }

}