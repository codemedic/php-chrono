<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use DateTime;
use RedMatter\Chrono\Clock\Clock;
use RedMatter\Chrono\Clock\SteadyClock;

class Time implements CalendarTimeInterface
{
    use TimeTrait;
    use CalendarTimeTrait;

    /**
     * Convert SteadyTime to Time
     *
     * NOTE: Accuracy will be affected by the PHP version; php >= 7.3 preferred
     *
     * @param SteadyTime $t
     *
     * @return Time
     */
    public static function fromSteadyTime(SteadyTime $t)
    {
        $steadyClock = new SteadyClock();
        $clock = new Clock();

        return $clock->now()
            ->after(
                $t->diff($steadyClock->now())
            );
    }

    /**
     * Convert DateTime to Time
     *
     * @param DateTime $time
     *
     * @return Time
     */
    public static function fromDateTime(DateTime $time)
    {
        $sinceEpoch = $time->format('U.u');

        return new self((float)$sinceEpoch);
    }
}
