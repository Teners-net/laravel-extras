<?php

namespace Platinum\LaravelExtras\Commands;

use Illuminate\Support\Str;
use Platinum\LaravelExtras\Helpers\CommandGenerator;
use Platinum\LaravelExtras\Helpers\FileGenerator;
use Platinum\LaravelExtras\Helpers\GenerateFileContent;

class MakeTraitCommand extends CommandGenerator
{
    public $argumentName = 'name';
    protected $stubPath = __DIR__.'/../stubs/traits.stub';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait 
      {name : The name of the trait class}
      {--force : Create the class even if the model already exists}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new trait';

    /**
     * Get the Trait name in studly format
     */
    private function getTraitName(): string
    {
        return Str::studly($this->argument('name'));
    }

    /**
     * getDestinationFilePath
     *
     * @return string
     */
    protected function getDestinationFilePath(): string
    {
        return app_path().'/Traits/'. $this->getTraitName() . '.php';
    }

    /**
     * getTraitNameWithoutNamespace
     *
     * @return string
     */
    private function getTraitNameWithoutNamespace(): string
    {
        return class_basename($this->getTraitName());
    }

    /**
     * Get Default Namespace
     *
     * @return string
     */
    public function getDefaultNamespace() : string
    {
        return "App\\Traits";
    }

    /**
     * Check for overide --force option
     */
    public function useOveride(): bool
    {
      return $this->option('force');
    }

    /**
     * Get Template Content
     */
    protected function getTemplateContent(): string
    {
        return (
            new GenerateFileContent
            (
                $this->stubPath, 
                [
                  'CLASS_NAMESPACE' => $this->getClassNamespace(),
                  'CLASS_NAME'      => $this->getTraitNameWithoutNamespace()
                ]
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
            $this->info("Created the 'Trait' folder");
        }

        $contents = $this->getTemplateContent();

        try {
            (new FileGenerator($path, $contents, $this->useOveride()))->generateFile();
            
            $this->info("Created trait: {$path}");
        } catch (\Exception $e) {

            $this->error("File : {$e->getMessage()}");

            return E_ERROR;
        }

        return $this::SUCCESS;

    }

}