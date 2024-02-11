<?php

namespace Teners\LaravelExtras\Tests\Feature\Helpers;

use Illuminate\Filesystem\Filesystem;
use Teners\LaravelExtras\Helpers\FileGenerator;

$path = __DIR__ . '/../../test-output/generated.txt';
$content = "This file is generated";
$filesystem = new Filesystem;

it(
    'can generate file with path and content only',
    function () use ($path, $content) {
        $generator = new FileGenerator($path, $content);
        $result = $generator->generateFile();

        expect($result)->toBeTrue();
    }
);

it(
    'can throw file exist error',
    function () use ($path, $content, $filesystem) {
        $generator = new FileGenerator($path, $content, $filesystem);
        expect(fn () => $generator->generateFile())->toThrow('File already exists!');

        $filesystem->delete($path);
    }
);

it(
    'can generate file with custom filesystem and overwrite',
    function () use ($path, $content, $filesystem) {
        $generator = new FileGenerator($path, $content, $filesystem);

        $result = $generator->generateFile(true);
        expect($result)->toBeTrue();

        $filesystem->delete($path);
    }
);
