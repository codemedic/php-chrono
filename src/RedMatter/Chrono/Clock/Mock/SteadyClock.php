<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock\Mock;

use RedMatter\Chrono\Clock\SteadyClockInterface;
use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Duration\Unit;
use RedMatter\Chrono\Time\SteadyTime;

/**
 * Mock Clock that provides `\RedMatter\Chrono\SteadyClockInterface`.
 */
class SteadyClock implements SteadyClockInterface
{
    private $time = 0;

    /**
     * Set the time
     *
     * @param SteadyTime $time
     */
    public function setTime(SteadyTime $time)
    {
        $this->time = (float)$time->secondsSinceEpoch();
    }

    /**
     * @see ClockInterface::elapse()
     *
     * <p>
     * NOTE: This mock version returns true always.
     *
     * @param Duration $duration
     *
     * @return bool
     */
    public function elapse(Duration $duration)
    {
        $this->time += $duration->value(Unit::NANOSECONDS);

        return true;
    }

    /**
     * @see ClockInterface::now()
     *
     * @return SteadyTime
     */
    public function now()
    {
        return new SteadyTime($this->time / 1e9);
    }
}
