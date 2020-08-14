<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Time\SteadyTime;

interface SteadyClockInterface
{
    /**
     * Get current monotonic-time.
     * <p>
     * When used with PHP 7.3 or later, the time readings returned are free from changes
     * due to clock synchronization. Even though older versions of PHP, which uses
     * `microtime` under the hood, are affected by clock synchronization, it is still
     * the best available option.
     *
     * @return SteadyTime
     */
    public function now();

    /**
     * When the function returns, the clock would have elapsed by the specified duration.
     * <p>
     * Returns false on failure or interruptions; otherwise true.
     *
     * @param Duration $duration
     *
     * @return bool
     */
    public function elapse(Duration $duration);
}
