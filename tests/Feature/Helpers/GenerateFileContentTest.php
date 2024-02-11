<?php

namespace Teners\LaravelExtras\Tests\Feature\Helpers;

use Teners\LaravelExtras\Helpers\GenerateFileContent;

// Set up the test data
$path = __DIR__ . '/../../test-stub/original.stub';
$replaces = ['NAME' => 'Emmanuel', 'AGE' => 24];
$outputPath = '/../test-output/output.txt';

it('can generate content and save to a file', function () use ($path, $replaces, $outputPath) {

    // Set the base path for output files
    GenerateFileContent::setBasePath(__DIR__);

    // Create a new instance of the GenerateFileContent class
    $generator = new GenerateFileContent($path, $replaces);

    // Generate the content and save to a file
    $result = $generator->generateContentWithPath($outputPath);

    // Assert that the file was created successfully
    expect($result)->toBeTrue();

    // Assert that the content of the created file is correct
    $generatedContent = file_get_contents(__DIR__ . $outputPath);
    expect($generatedContent)->toContain('My name is Emmanuel');
    expect($generatedContent)->toContain('I am 24 years old');
});

it('can generate content without saving to a file', function () use ($path, $replaces) {

    $generator = new GenerateFileContent($path, $replaces);

    $result = $generator->generateContent();

    expect($result)->toContain('My name is Emmanuel');
    expect($result)->toContain('I am 24 years old');
});
