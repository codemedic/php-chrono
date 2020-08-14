<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use RedMatter\Chrono\Time\SteadyTime;

/**
 * Wraps `hrtime` to get monotonic time.
 * <p>
 * NOTE: Proper implementation of `\hrtime` is only available in `php >= 7.3`; without it the accuracy of
 * `SteadyClock` will be affected by clock adjustments, either due to NTP sync or manual changes to system time.
 */
class SteadyClock implements SteadyClockInterface
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
