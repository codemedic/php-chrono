<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock\Mock;

use PHPUnit\Framework\TestCase;
use RedMatter\Chrono\Duration\MicroSeconds;
use RedMatter\Chrono\Duration\MilliSeconds;
use RedMatter\Chrono\Duration\Seconds;

class ClockTest extends TestCase
{
    public function testSteadyClock()
    {
        $clock = new SteadyClock();
        $t1 = $clock->now()->secondsSinceEpoch()->value();
        self::assertEquals(0, $t1);

        $clock->elapse(new Seconds(10.1));
        self::assertEquals(10.1, $clock->now()->secondsSinceEpoch()->value());
        $clock->elapse(new MilliSeconds(899.9));
        self::assertEquals(10.9999, $clock->now()->secondsSinceEpoch()->value());
        $clock->elapse(new MicroSeconds(100));
        self::assertEquals(11, $clock->now()->secondsSinceEpoch()->value());
    }
}
