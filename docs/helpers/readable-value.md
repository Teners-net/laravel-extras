# ReadableValue

This class provides some helper methods to format values in a human-readable way.

```php
use Platinum\LaravelExtras\Helpers\ReadableValue;
```

## Methods

### 1. realSize()
```php 
realSize(float $value, bool $useByte = true, int $precision = 2): string
```
This method takes a file size value in bytes and converts it to a human-readable format (e.g. KB, MB, GB). The second parameter $useByte is optional and if set to false, uses SI units (e.g. Kb, Mb, Gb) instead of binary units (e.g. KiB, MiB, GiB).

Example
```php
$size = ReadableValue::realSize(1024 * 1024);
echo $size; // Output: 1 MB

$size = ReadableValue::realSize(1024 * 1024, false);
echo $size; // Output: 1.05 Mb
```

### 2. duration()
```php 
duration(int $seconds): string
```
This method takes a duration value in seconds and converts it to a human-readable format (e.g. "1 hour 30 minutes", "2 minutes").

Example
```php
$duration = ReadableValue::duration(7200);
echo $duration; // Output: 2 hours
```

### 3. toPercentage()
```php 
toPercentage(float $value, float $total = 100, int $precision = 2): string
```
This method takes a decimal value and returns it as a percentage with the specified precision. The second parameter $total is optional and is used to specify the maximum value of the percentage. If $total is set to 0, the method will return '0%'.

Example
```php
$percentage = ReadableValue::toPercentage(75, 100);
echo $percentage; // Output: 75.00%
```

### 4. ordinalSuffix()
```php 
ordinalSuffix(int $number): string
```
This method adds an ordinal suffix to a number (e.g. 1st, 2nd, 3rd, 4th, etc.).

Example
```php
$ordinal = ReadableValue::ordinalSuffix(21);
echo $ordinal; // Output: 21st
```