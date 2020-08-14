<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Duration;

/**
 * Duration unit constants and utilities.
 */
final class Unit
{
    const NANOSECONDS = 1e0;
    const MICROSECONDS = 1e3;
    const MILLISECONDS = 1e6;
    const SECONDS = 1e9;
    const MINUTES = 60e9;
    const HOURS = 3600e9;
    const DAYS = 86400e9;

    const UNCHANGED = -1e0;
    const UNKNOWN = -2e0;

    /**
     * Get unit name from constants; returns null if not a predefined unit
     *
     * @param float $unit
     * @param bool $plural
     *
     * @return string|null
     */
    public static function toString($unit, $plural = false)
    {
        switch ($unit) {
            case self::NANOSECONDS:
                $str = "nanosecond";
                break;
            case self::MICROSECONDS:
                $str = "microsecond";
                break;
            case self::MILLISECONDS:
                $str = "millisecond";
                break;
            case self::SECONDS:
                $str = "second";
                break;
            case self::MINUTES:
                $str = "minute";
                break;
            case self::HOURS:
                $str = "hour";
                break;
            case self::DAYS:
                $str = "day";
                break;
            default:
                return null;
        }

        if ($plural) {
            $str .= 's';
        }

        return $str;
    }

    /**
     * Get string representation for a custom unit. If the unit matches one of the
     * predefined ones, then that will be chosen.
     *
     * @param float $unit
     * @return string
     */
    public static function customUnitToString($unit)
    {
        $baseUnit = self::SECONDS;
        switch (true) {
            case $unit < self::NANOSECONDS:
                $baseUnit = self::NANOSECONDS;
                break;
            case $unit < self::MICROSECONDS:
                $baseUnit = self::MICROSECONDS;
                break;
            case $unit < self::MILLISECONDS:
                $baseUnit = self::MILLISECONDS;
                break;
            case $unit < self::SECONDS:
                $baseUnit = self::SECONDS;
                break;
            case $unit < self::MINUTES:
                $baseUnit = self::MINUTES;
                break;
            case $unit < self::HOURS:
                $baseUnit = self::HOURS;
                break;
            case $unit < self::DAYS:
                $baseUnit = self::DAYS;
                break;
        }

        $fraction = $baseUnit / $unit;
        return sprintf("%s/{$fraction}", self::toString($baseUnit));
    }
}
