<?php

namespace Teners\LaravelExtras\Helpers;

class GenerateFileContent
{
    protected string $path;
    protected static string $basePath = '';
    protected array $replaces = [];

    /**
     * __construct
     *
     * @param  string $path
     * @param  array $replaces
     */
    public function __construct(string $path, array $replaces = [])
    {
        $this->path = $path;
        $this->replaces = $replaces;
    }

    /**
     * Generate file content with replaced values and save to file
     *
     * @param  string $outputPath
     * @return bool
     */
    public function generateContent(): string
    {
        $contents = file_get_contents($this->path);

        foreach ($this->replaces as $search => $replace) {
            $contents = str_replace($search, $replace, $contents);
        }

        return $contents;
    }

    /**
     * Generate file content with replaced values and save to file
     *
     * @param  string $outputPath
     * @return bool
     */
    public function generateContentWithPath(string $outputPath): bool
    {
        $contents = $this->generateContent();

        return file_put_contents(static::$basePath . $outputPath, $contents) !== false;
    }

    /**
     * Set the base path for output files
     *
     * @param  string|null $basePath
     * @return void
     */
    public static function setBasePath(?string $basePath): void
    {
        static::$basePath = $basePath ?: '';
    }
}
