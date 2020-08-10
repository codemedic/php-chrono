<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Duration\Unit;

trait SleepableClockTrait
{
    /**
     * @inheritDoc
     */
    public function elapse(Duration $duration)
    {
        return true === time_nanosleep(0, $duration->value(Unit::NANOSECONDS));
    }
}