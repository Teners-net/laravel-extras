<?php

namespace Teners\LaravelExtras\Helpers;

use Illuminate\Filesystem\Filesystem;

class FileGenerator
{
    protected string $path;
    protected string $content;
    protected Filesystem $filesystem;

    public function __construct(
        string $path,
        mixed $content,
        ?Filesystem $filesystem = null
    ) {
        $this->path = $path;
        $this->content = $content;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    /**
     * Generate the file
     *
     * @param bool $overwrite Whether to overwrite if file exists
     * @throws \Exception
     */
    public function generateFile(bool $overwrite = true): mixed
    {
        if (!$overwrite && $this->filesystem->exists($this->path)) {
            throw new \Exception('File already exists!');
        }

        $this->filesystem->ensureDirectoryExists(dirname($this->path));

        $this->filesystem->put($this->path, $this->content);

        return true;
    }
}
