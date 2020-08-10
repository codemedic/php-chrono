<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock\Mock;

use RedMatter\Chrono\Clock\ClockInterface;
use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Duration\Unit;
use RedMatter\Chrono\Time\SteadyTime;

class SteadyClock implements ClockInterface
{
    private $time = 0;

    public function setTime(SteadyTime $time)
    {
        $this->time = (float)$time->secondsSinceEpoch();
    }

    /**
     * @inheritDoc
     */
    public function elapse(Duration $duration)
    {
        $this->time += $duration->value(Unit::NANOSECONDS);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function now()
    {
        return new SteadyTime($this->time / 1e9);
    }
}
