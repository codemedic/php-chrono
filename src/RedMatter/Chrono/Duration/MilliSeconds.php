<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Duration;

final class MilliSeconds extends Duration
{
    const UNIT = Unit::MILLISECONDS;

    public function __construct($value)
    {
        parent::__construct($value, self::UNIT);
    }
}
