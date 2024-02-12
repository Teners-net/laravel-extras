<?php

namespace Teners\LaravelExtras\Tests\Unit;

use function PHPUnit\Framework\assertArrayHasKey;

it('can_get_config_values', function () {
    $config = config('laravel-extras');

    assertArrayHasKey('source_column', $config);
    assertArrayHasKey('slug_column', $config);
    assertArrayHasKey('slug_as_route', $config);
});