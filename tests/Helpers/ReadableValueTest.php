<?php

use Platinum\LaravelExtras\Helpers\ReadableValue;

it('can convert file size to human readable format', function () {
    $value = 1024 * 1024;
    expect(ReadableValue::realSize($value))->toBe('1 MB');
});

it('can convert file size to SI unit', function () {
    $value = 1024 * 1024;
    expect(ReadableValue::realSize($value, false))->toBe('1.05 Mb');
});

it('can get duration in human readable format', function () {
    $seconds = 3600;
    expect(ReadableValue::duration($seconds))->toBe('1 hour');
});

it('can format decimal value as percentage', function () {
    $value = 75;
    $total = 100;
    expect(ReadableValue::toPercentage($value, $total))->toBe('75.00%');
});

it('can add ordinal suffix to a number', function () {
    $number = 21;
    expect(ReadableValue::ordinalSuffix($number))->toBe('21st');
});
