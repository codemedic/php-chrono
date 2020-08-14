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

        $timeFromSteadyTime = CalendarTime::fromSteadyTime($steadyTime);

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

        $timeFromDateTime = CalendarTime::fromDateTime($dateTime);

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
     * @param CalendarTime     $time
     * @param Duration $duration
     * @param CalendarTime     $expected
     */
    public function testOperations(CalendarTime $time, Duration $duration, CalendarTime $expected)
    {
        $timeValue = $time->secondsSinceEpoch()->value();

        $after = $time->after($duration);
        self::assertTrue($after->isEqual($expected));

        // ensure that $time is not modified
        self::assertEquals($timeValue, $time->secondsSinceEpoch()->value());

        self::assertTrue($after->diff($time)->isEqual($duration));
    }

    /**
     * @dataProvider providesTestIsEqualData
     *
     * @param TimeInterface $lhs
     * @param TimeInterface $rhs
     * @param $isEqual
     */
    public function testIsEqual(TimeInterface $lhs, TimeInterface $rhs, $isEqual)
    {
        self::assertTrue($isEqual === $lhs->isEqual($rhs));
    }

    /**
     * @dataProvider providesTestDiffData
     *
     * @param TimeInterface $lhs
     * @param TimeInterface $rhs
     * @param Duration|null $diff
     */
    public function testDiff(TimeInterface $lhs, TimeInterface $rhs, Duration $diff = null)
    {
        if (get_class($lhs) !== get_class($rhs)) {
            $this->setExpectedException('InvalidArgumentException');
            $lhs->diff($rhs);
        } else {
            $this->setExpectedException(null);
            $got = $lhs->diff($rhs);
            self::assertTrue($diff->isEqual($got));
        }
    }

    /**
     * @dataProvider providesTestToStringData
     *
     * @param CalendarTime $t
     * @param $str
     */
    public function testToString(CalendarTime $t, $str)
    {
        self::assertEquals($str, (string)$t);
    }

    /**
     * @dataProvider providesTestBeforeData
     * @param TimeInterface $time
     * @param Duration $duration
     */
    public function testBefore(TimeInterface $time, Duration $duration)
    {
        static $zeroDuration;
        if (!$zeroDuration) {
            $zeroDuration = new Seconds(0);
        }

        $tBefore = $time->before($duration);

        self::assertTrue(
            $time->diff($tBefore)
                ->isEqual($duration)
        );

        $cmp = $duration->compare($zeroDuration);
        switch (true) {
            case $cmp < 0:
                self::assertTrue($time->isBefore($tBefore));
                break;
            case $cmp === 0:
                self::assertTrue($time->isEqual($tBefore));
                break;
            case $cmp > 0:
                self::assertTrue($time->isAfter($tBefore));
                break;
        }
    }

    public function providesTestOperationsData()
    {
        $now = new CalendarTime(0.0);

        return [
            [$now, new Days(1), new CalendarTime(86400)],
            [$now, new Hours(1), new CalendarTime(3600)],
            [$now, new Minutes(1), new CalendarTime(60)],
            [$now, new Seconds(10), new CalendarTime(10)],
            [$now, new MilliSeconds(10), new CalendarTime(0.01)],
            [$now, new MicroSeconds(10), new CalendarTime(0.00001)],
            [$now, new NanoSeconds(10), new CalendarTime(0.00000001)],
            [$now, new NanoSeconds(0), new CalendarTime(0)],
        ];
    }

    public function providesTestIsEqualData()
    {
        return [
            [new CalendarTime(1.0), new SteadyTime(1.0), false],
            [new CalendarTime(1.0), new CalendarTime(1.0), true],
            [new SteadyTime(1.0), new SteadyTime(1.0), true],
            [new CalendarTime(0), new CalendarTime(0), true],
            [new SteadyTime(0), new SteadyTime(0), true],
        ];
    }

    public function providesTestDiffData()
    {
        return [
            [new CalendarTime(1), new CalendarTime(2), new Seconds(-1)],
            [new CalendarTime(0), new CalendarTime(2), new Seconds(-2)],
            [new CalendarTime(-1), new CalendarTime(2), new Seconds(-3)],
            [new CalendarTime(1), new SteadyTime(2)],
            [new SteadyTime(1), new CalendarTime(2)],
        ];
    }

    public function providesTestToStringData()
    {
        return [
            [new CalendarTime(0), '1970-01-01T00:00:00.000000+00:00'],
            [new CalendarTime(-1), '1969-12-31T23:59:59.000000+00:00'],
        ];
    }

    public function providesTestBeforeData()
    {
        return [
            [new CalendarTime(1), new Seconds(1)],
            [new CalendarTime(1), new Seconds(-1)],
            [new CalendarTime(0), new Seconds(-1)],
            [new CalendarTime(-1), new Seconds(-1)],
            [new SteadyTime(1), new Seconds(1)],
            [new SteadyTime(1), new Seconds(-1)],
            [new SteadyTime(0), new Seconds(-1)],
            [new SteadyTime(-1), new Seconds(-1)],
        ];
    }
}
