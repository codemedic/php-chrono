<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use RedMatter\Chrono\Time\CalendarTime;

/**
 * Wraps `\microtime` to get calendar time.
 */
class Clock implements ClockInterface
{
    use SleepableClockTrait;

    /**
     * @inheritDoc
     */
    public function now()
    {
        return new CalendarTime(microtime(true));
    }
}
