<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use PHPUnit\Framework\TestCase;
use RedMatter\Chrono\Clock\Mock\SteadyClock as MockSteadyClock;
use RedMatter\Chrono\Clock\Mock\Clock as MockClock;
use RedMatter\Chrono\Duration\Seconds;

class ClockTest extends TestCase
{
    /**
     * @dataProvider providesClock
     *
     * @param ClockInterface|SteadyClockInterface $clock
     */
    public function testTime($clock)
    {
        $t1 = $clock->now()->secondsSinceEpoch()->value();
        $clock->elapse(new Seconds(0.1));
        $t2 = $clock->now()->secondsSinceEpoch()->value();
        self::assertEquals(0.1, $t2 - $t1, '', 0.001);
    }

    public function providesClock()
    {
        return [
            [new Clock()],
            [new MockClock()],
            [new SteadyClock()],
            [new MockSteadyClock()],
        ];
    }
}
