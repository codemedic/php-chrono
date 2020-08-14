<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use RedMatter\Chrono\Duration\Duration;

/**
 * `SynchronisedClock` wraps both calendar-clock and monotonic-clock for use-cases that require both the clocks.
 */
class SynchronisedClock implements SynchronisedClockInterface
{
    use SleepableClockTrait;

    /** @var CalendarClock */
    protected $clock;
    /** @var SteadyClock */
    protected $steadyClock;

    public function __construct()
    {
        $this->clock = new CalendarClock();
        $this->steadyClock = new SteadyClock();
    }

    /**
     * @inheritDoc
     */
    public function getTime()
    {
        return $this->clock->now();
    }

    /**
     * @inheritDoc
     */
    public function getSteadyTime()
    {
        return $this->steadyClock->now();
    }

    /**
     * @inheritDoc
     */
    public function perform(callable $f, Duration &$d = null)
    {
        if (1 === func_num_args()) {
            return $f();
        }

        $startTime = $this->steadyClock->now();

        $ret = $f();

        $d = $this->steadyClock->now()
            ->diff($startTime);

        return $ret;
    }
}
