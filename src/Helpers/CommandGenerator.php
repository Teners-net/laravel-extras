<?php

namespace Platinum\LaravelExtras\Helpers;

use Illuminate\Console\Command;

abstract class CommandGenerator extends Command
{
    public const APP_PATH = 'App';

    public $argumentName;

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
        $extra = str_replace(array($this->getClass(), '/'), array('', '\\'), $this->argument($this->argumentName));

        $namespace = $this->getDefaultNamespace();

        $namespace .= '\\' . $extra;

        $namespace = str_replace('/', '\\', $namespace);

        return trim($namespace, '\\');
    }

    /**
     * Check for overide --force option
     */
    public function useOveride(): bool
    {
      return $this->option('force');
    }

}