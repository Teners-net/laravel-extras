<?php

namespace Teners\LaravelExtras\Helpers;

use Illuminate\Console\Command;

abstract class CommandGenerator extends Command
{
    public const APP_PATH = 'App';

    public string $argumentName = 'name';

    /**
     * Return the rendered File Content
     */
    abstract protected function getTemplateContent(): string;

    /**
     * Return the destination path for publish created class file.
     */
    abstract protected function getDestinationFilePath(): string;

    /**
     * Return the class name
     */
    public function getClass(): string
    {
        return class_basename($this->argument($this->argumentName));
    }

    /**
     * Get class namespace
     */
    public function getClassNamespace(): string
    {
        if (method_exists($this, 'getNamespace')) {
            return $this->getNamespace();
        }

        if (method_exists($this, 'getDefaultNamespace')) {
            return '';
        }

        $extra = str_replace(
            [$this->getClass(), '/'],
            ['', '\\'],
            $this->argument($this->argumentName)
        );

        $namespace = trim($this->getDefaultNamespace() . '\\' . $extra, '\\');

        return str_replace('/', '\\', $namespace);
    }

    /**
     * Check for override --force option
     *
     * @return bool
     */
    protected function useOverride(): bool
    {
        return $this->option('force') ?? false;
    }

    protected function ensureDirectoryExists(string $path): void
    {
        $directory = dirname($path);
        if (!$this->laravel['files']->isDirectory($directory)) {
            $this->laravel['files']->makeDirectory($directory, 0755, true);
        }
    }
}
