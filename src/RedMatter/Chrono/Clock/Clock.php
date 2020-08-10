<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use RedMatter\Chrono\Time\Time;

class Clock implements ClockInterface
{
    use SleepableClockTrait;

    /**
     * @inheritDoc
     */
    public function now()
    {
        return new Time(microtime(true));
    }
}
