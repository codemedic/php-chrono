<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock\Mock;

use DateTime;
use RedMatter\Chrono\Clock\CalendarClockInterface;
use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Duration\Unit;
use RedMatter\Chrono\Time\CalendarTime;
use RuntimeException;

/**
 * Mock Clock that models calendar-clock.
 *
 * @see \RedMatter\Examples\CuckooClockTest
 */
class CalendarClock implements CalendarClockInterface
{
    private $time = 0;

    /**
     * Set the time
     *
     * @param CalendarTime $time
     */
    public function setTime(CalendarTime $time)
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
        $this->setTime(CalendarTime::fromDateTime($time));
    }

    /**
     * @param Duration $duration
     *
     * @return bool
     *@see CalendarClockInterface::elapse()
     *
     * <p>
     * NOTE: The mock version would always return true.
     *
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
     * @return CalendarTime
     *@see CalendarClockInterface::now()
     *
     */
    public function now()
    {
        return new CalendarTime($this->time / 1e9);
    }
}
