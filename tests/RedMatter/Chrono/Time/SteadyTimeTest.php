<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use PHPUnit\Framework\TestCase;
use RedMatter\Chrono\Clock\Clock;
use RedMatter\Chrono\Clock\SteadyClock;

class SteadyTimeTest extends TestCase
{
    public function testFromTime()
    {
        $clock = new Clock();
        $steadyClock = new SteadyClock();

        $time = $clock->now();
        $steadyTime = $steadyClock->now();

        $steadyTimeFromTime = SteadyTime::fromTime($time);

        self::assertEquals(
            $steadyTime->secondsSinceEpoch()->value(),
            $steadyTimeFromTime->secondsSinceEpoch()->value(),
            '',
            0.0005 // for php < 7.3
        );
    }
}
