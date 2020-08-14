<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock\Mock;

use DateTime;
use RedMatter\Chrono\Clock\ClockInterface;
use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Duration\Unit;
use RedMatter\Chrono\Time\Time;
use RuntimeException;

/**
 * Mock Clock that provides `\RedMatter\Chrono\ClockInterface`.
 *
 * @see \RedMatter\Examples\CuckooClockTest
 */
class Clock implements ClockInterface
{
    private $time = 0;

    /**
     * Set the time
     *
     * @param Time $time
     */
    public function setTime(Time $time)
    {
        $this->time = (float)$time->secondsSinceEpoch()->value(Unit::NANOSECONDS);
    }

    /**
     * Set the time from DateTime
     *
     * @param DateTime $time
     */
    public function setDateTime(DateTime $time)
    {
        $this->setTime(Time::fromDateTime($time));
    }

    /**
     * @see ClockInterface::elapse()
     *
     * <p>
     * NOTE: The mock version would always return true.
     *
     * @param Duration $duration
     *
     * @return bool
     */
    public function elapse(Duration $duration)
    {
        $nanoseconds = $duration->value(Unit::NANOSECONDS);
        if ($nanoseconds < 0) {
            throw new RuntimeException("Clock cannot go backwards");
        }

        $this->time += $nanoseconds;

        return true;
    }

    /**
     * @see ClockInterface::now()
     *
     * @return Time
     */
    public function now()
    {
        return new Time($this->time / 1e9);
    }
}
