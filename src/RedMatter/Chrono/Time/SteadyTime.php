<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use RedMatter\Chrono\Clock\Clock;
use RedMatter\Chrono\Clock\SteadyClock;

class SteadyTime implements TimeInterface
{
    use TimeTrait;

    /**
     * Convert Time to SteadyTime
     *
     * NOTE: Accuracy will be affected by the PHP version; php >= 7.3 preferred
     *
     * @param Time $t
     *
     * @return SteadyTime
     */
    public static function fromTime(Time $t)
    {
        $steadyClock = new SteadyClock();
        $clock = new Clock();

        return $steadyClock->now()
            ->after(
                $t->diff($clock->now())
            );
    }
}
