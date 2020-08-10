<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use RedMatter\Chrono\Time\SteadyTime;

class SteadyClock implements ClockInterface
{
    use SleepableClockTrait;

    /**
     * @inheritDoc
     */
    public function now()
    {
        $nanoseconds = hrtime(true);

        return new SteadyTime($nanoseconds * 1e-9);
    }
}
