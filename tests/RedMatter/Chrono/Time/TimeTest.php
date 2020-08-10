<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use DateTime;
use PHPUnit\Framework\TestCase;
use RedMatter\Chrono\Clock\Clock;
use RedMatter\Chrono\Clock\SteadyClock;
use RedMatter\Chrono\Duration\Days;
use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Duration\Hours;
use RedMatter\Chrono\Duration\MicroSeconds;
use RedMatter\Chrono\Duration\MilliSeconds;
use RedMatter\Chrono\Duration\Minutes;
use RedMatter\Chrono\Duration\NanoSeconds;
use RedMatter\Chrono\Duration\Seconds;

class TimeTest extends TestCase
{
    public function testFromSteadyTime()
    {
        $clock = new Clock();
        $steadyClock = new SteadyClock();

        $time = $clock->now();
        $steadyTime = $steadyClock->now();

        $timeFromSteadyTime = Time::fromSteadyTime($steadyTime);

        self::assertEquals(
            $time->secondsSinceEpoch()->value(),
            $timeFromSteadyTime->secondsSinceEpoch()->value(),
            '',
            0.005 // for php < 7.3
        );
    }

    public function testFromDateTime()
    {
        $clock = new Clock();
        $time = $clock->now();

        // create a DateTime with higher precision time
        $dateTime = DateTime::createFromFormat('U.u', microtime(true));

        $timeFromDateTime = Time::fromDateTime($dateTime);

        self::assertEquals(
            $time->secondsSinceEpoch()->value(),
            $timeFromDateTime->secondsSinceEpoch()->value(),
            '',
            0.0005 // for php < 7.3
        );
    }

    /**
     * @dataProvider providesTestOperationsData
     *
     * @param Time     $time
     * @param Duration $duration
     * @param Time     $expected
     */
    public function testOperations(Time $time, Duration $duration, Time $expected)
    {
        $timeValue = $time->secondsSinceEpoch()->value();

        $after = $time->after($duration);
        self::assertTrue($after->isEqual($expected));

        // ensure that $time is not modified
        self::assertEquals($timeValue, $time->secondsSinceEpoch()->value());

        self::assertTrue($after->diff($time)->isEqual($duration));
    }

    public function providesTestOperationsData()
    {
        $now = new Time(0.0);

        return [
            [$now, new Days(1), new Time(86400)],
            [$now, new Hours(1), new Time(3600)],
            [$now, new Minutes(1), new Time(60)],
            [$now, new Seconds(10), new Time(10)],
            [$now, new MilliSeconds(10), new Time(0.01)],
            [$now, new MicroSeconds(10), new Time(0.00001)],
            [$now, new NanoSeconds(10), new Time(0.00000001)],
            [$now, new NanoSeconds(0), new Time(0)],
        ];
    }
}
