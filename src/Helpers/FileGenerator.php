<?php

namespace Platinum\LaravelExtras\Helpers;

use Illuminate\Filesystem\Filesystem;

class FileGenerator
{
    protected string $path;
    protected string $content;
    protected bool $overwrite;
    protected Filesystem $filesystem;

    /**
     * __construct
     *
     * @param string $path
     * @param mixed $content
     * @param bool $overwrite
     * @param Filesystem $filesystem
     */
    public function __construct(
        string $path,
        mixed $content,
        bool $overwrite = false,
        Filesystem $filesystem = null
    ) {
        $this->path = $path;
        $this->content = $content;
        $this->overwrite = $overwrite;
        $this->filesystem = $filesystem ?: new Filesystem();
    }

    /**
     * Generate the file
     *
     * @param bool $overwrite
     * @throws \Exception
     */
    public function generateFile(bool $overwrite = false): mixed
    {
        $path = $this->path;

        if (!$this->filesystem->exists($path)) {
            return $this->filesystem->put($path, $this->content);
        }

        $shouldOverwrite = $overwrite ?? $this->overwrite;

        if ($shouldOverwrite) {
            return $this->filesystem->put($path, $this->content);
        }

        throw new \Exception('File already exists!');
    }
}
