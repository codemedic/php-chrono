<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use DateTime;
use DateTimeZone;
use RedMatter\Chrono\Clock\CalendarClock;
use RedMatter\Chrono\Clock\SteadyClock;

class CalendarTime implements TimeInterface, CalendarTimeInterface
{
    use TimeTrait;
    use CalendarTimeTrait;

    const DEFAULT_FORMAT = 'Y-m-d\TH:i:s.uP';

    /**
     * Convert monotonic-time to calendar-time
     * <p>
     * NOTE: Accuracy will be affected by the PHP version; php >= 7.3 preferred
     *
     * @param SteadyTime $t
     *
     * @return CalendarTime
     */
    public static function fromSteadyTime(SteadyTime $t)
    {
        $steadyClock = new SteadyClock();
        $clock = new CalendarClock();

        return $clock->now()
            ->after(
                $t->diff($steadyClock->now())
            );
    }

    /**
     * Convert DateTime to calendar-time.
     *
     * @param DateTime $time
     *
     * @return CalendarTime
     */
    public static function fromDateTime(DateTime $time)
    {
        $sinceEpoch = $time->format('U.u');

        return new self((float)$sinceEpoch);
    }

    /**
     * Format time using DateTime::format
     *
     * @param string $fmt
     * @param DateTimeZone|null $timeZone
     *
     * @return string
     */
    public function format($fmt = self::DEFAULT_FORMAT, DateTimeZone $timeZone = null)
    {
        return $this->getDateTime($timeZone)->format($fmt);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->format();
    }
}
