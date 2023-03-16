<?php

namespace Platinum\LaravelExtras\Helpers;

class ReadableValue
{
    /**
     * Convert file size in byte/Byte to human readable format
     * 
     * @param float $value
     * @param bool $useByte Use binary or SI Unit
     * @param int $precision The number of decimal place
     */
    public static function realSize(float $value, bool $useByte = true, int $precision = 2): string
    {
        $base = $useByte ? 1024 : 1000;
        $units = $useByte ? ['B', 'KB', 'MB', 'GB', 'TB', 'PB'] : ['b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb'];

        for ($i = 0; $value > $base; $i++) {
            $value /= $base;
        }

        return round($value, $precision) . ' ' . $units[$i];
    }

    /**
     * Get duration in human readable format
     */
    public static function duration(int $seconds): string
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $duration = '';

        if ($hours > 0) {
            $duration .= $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ';
        }

        if ($minutes > 0) {
            $duration .= $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ';
        }

        if (empty($duration)) {
            $duration .= '0 minutes';
        }

        return trim($duration);
    }

    /**
     * Format a decimal value as a percentage with the specified precision.
     */
    public static function toPercentage(float $value, float $total = 100, int $precision = 2): string
    {
        if ($total == 0) {
            return '0%';
        }

        return number_format($value / $total * 100, $precision) . '%';
    }

    /**
     * Add an ordinal suffix to a number.
     */
    public static function ordinalSuffix(int $number): string
    {
        if (!in_array(($number % 100), [11, 12, 13])) {
            switch ($number % 10) {
                // Handle 1st, 2nd, 3rd
                case 1:
                    return $number . 'st';
                case 2:
                    return $number . 'nd';
                case 3:
                    return $number . 'rd';
            }
        }

        return $number . 'th';
    }
}
