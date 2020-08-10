<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Duration;

final class Unit
{
    const NANOSECONDS = 1e0;
    const MICROSECONDS = 1e3;
    const MILLISECONDS = 1e6;
    const SECONDS = 1e9;
    const MINUTES = 60e9;
    const HOURS = 3600e9;
    const DAYS = 86400e9;

    const UNCHANGED =  -1e0;
    const UNKNOWN =  -2e0;
}
