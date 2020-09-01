<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Time\SteadyTime;
use RedMatter\Chrono\Time\CalendarTime;

/**
 * SynchronisedClockInterface is to be used in cases where the logic would rely on
 * both calendar and monotonic clocks.
 */
interface SynchronisedClockInterface
{
    /**
     * Get time from the embedded Clock.
     *
     * @return CalendarTime
     */
    public function getCalendarTime();

    /**
     * Get time from the embedded SteadyClock.
     *
     * @return SteadyTime
     */
    public function getSteadyTime();

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

    /**
     * Perform $f
     * <p>
     * When the function returns, the clock would have elapsed by the duration it took for $f to finish.
     * <p>
     * NOTE: This is meant for time sensitive use cases (from unit-testing perspective) where
     * both the clocks should absolutely be in sync.
     * <p>
     * Returns the return value from $f
     *
     * @param callable $f code to execute
     * @param Duration|null $d set to time spent to execute f
     *
     * @return mixed
     */
    public function perform(callable $f, Duration &$d = null);
}
