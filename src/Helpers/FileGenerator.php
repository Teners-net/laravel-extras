<?php

namespace Platinum\LaravelExtras\Helpers;

use Illuminate\Filesystem\Filesystem;

class FileGenerator
{
    protected string $path;
    protected string $content;
    protected Filesystem $filesystem;

    /**
     * __construct
     *
     * @param string $path
     * @param mixed $content
     * @param Filesystem $filesystem
     */
    public function __construct(
        string $path,
        mixed $content,
        Filesystem $filesystem = null
    ) {
        $this->path = $path;
        $this->content = $content;
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
            $this->filesystem->put($path, $this->content);
            return true;
        }

        $shouldOverwrite = $overwrite ?? $this->overwrite;

        if ($shouldOverwrite) {
            $this->filesystem->put($path, $this->content);
            return true;
        }

        throw new \Exception('File already exists!');
    }
}
