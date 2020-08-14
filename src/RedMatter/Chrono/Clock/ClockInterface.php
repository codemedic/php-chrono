<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Time\CalendarTime;

interface ClockInterface
{
    /**
     * Get current calendar-time.
     * <p>
     * Time readings returned are subject to changes for clock synchronization.
     * Difference between two values obtained after a specific duration need not be
     * the same at all times.
     *
     * @return CalendarTime
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
