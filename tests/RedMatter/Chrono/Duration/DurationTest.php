<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Duration;

use PHPUnit\Framework\TestCase;

class DurationTest extends TestCase
{
    /**
     * @dataProvider providesTestGetValueData
     *
     * @param $value
     * @param $unit
     * @param $getValue
     * @param $getUnit
     */
    public function testGetValue($value, $unit, $getValue, $getUnit)
    {
        $duration = new Duration($value, $unit);
        self::assertEquals($getValue, $duration->value($getUnit));
    }

    /**
     * @dataProvider providesTestGetValueWithOrWithoutUnitData
     *
     * @param Duration $duration
     * @param int|float $getValue
     * @param float $getUnit
     */
    public function testGetValueWithOrWithoutUnit(Duration $duration, $getValue, $getUnit)
    {
        if ($getUnit === null) {
            self::assertEquals($getValue, $duration->value());
        } else {
            self::assertEquals($getValue, $duration->value($getUnit));
        }
    }

    public function testAdd()
    {
        $d1 = new Seconds(10);
        $d2 = $d1->add(new Minutes(1));

        self::assertEquals(10, $d1->value());
        self::assertEquals(70, $d2->value());
        self::assertTrue($d2 instanceof Seconds);
        self::assertFalse($d2 instanceof Minutes);

        $d3 = new Duration(10, Unit::SECONDS / 10);
        $d4 = $d3->add(new Seconds(10));
        self::assertTrue($d4 instanceof Duration);
        self::assertFalse($d4 instanceof Seconds);
        self::assertEquals(110, $d4->value());
    }

    public function testSubtract()
    {
        $d1 = new Seconds(10);
        $d2 = $d1->add(new Minutes(1));
        $d3 = $d1->subtract($d2);
        self::assertEquals(10, $d1->value());
        self::assertEquals(70, $d2->value());
        self::assertEquals(-60, $d3->value());
        self::assertTrue($d3 instanceof Seconds);
    }

    public function testSlice()
    {
        $d1 = new Seconds(1);
        self::assertTrue($d1->slice(1000)->isEqual(new MilliSeconds(1)));
        self::assertTrue($d1->slice(1000) instanceof Seconds);

        $d2 = MilliSeconds::createFrom($d1)->slice(1000);
        self::assertTrue($d2 instanceof MilliSeconds);
        self::assertTrue($d2->isEqual(new MilliSeconds(1)));
    }

    public function testDivideFloat()
    {
        $d1 = new Seconds(1);
        self::assertEquals(1000, $d1->divideFloat(new MilliSeconds(1)));
        self::assertEquals(0.5, $d1->divideFloat(new Seconds(2)));
    }

    public function testDivideInt()
    {
        $interval = new MilliSeconds(1);

        $d = new Seconds(1);
        $times = $d->divideInt($interval);
        $modulo = $d->modulo($interval);
        self::assertEquals(1000, $times);
        self::assertTrue($modulo->isZero());

        $interval = new Seconds(2);

        $times = $d->divideInt($interval);
        $modulo = $d->modulo($interval);
        self::assertEquals(0, $times);
        self::assertTrue($modulo->isEqual(new Seconds(1)));
    }

    public function testModulo()
    {
        $d1 = new Seconds(11);
        $d2 = new MilliSeconds(5000);
        $modulo = $d1->modulo($d2);
        self::assertTrue($modulo->isEqual(new Seconds(1)));
        self::assertTrue($modulo instanceof Seconds);
        self::assertFalse($modulo instanceof MilliSeconds);

        $d1 = new Seconds(1.9081348923123);
        $d2 = new MilliSeconds(1000);
        $modulo = $d1->modulo($d2);

        $expectedModulo = new Seconds(0.9081348923123);
        self::assertTrue($expectedModulo->isEqual($modulo));
    }

    /**
     * @dataProvider providesTestIsEqual
     *
     * @param Duration $d1
     * @param Duration $d2
     * @param bool $isEqual
     */
    public function testIsEqual(Duration $d1, Duration $d2, $isEqual)
    {
        self::assertEquals($isEqual, $d1->isEqual($d2));
    }

    public function testCreateFrom()
    {
        $d1 = new Seconds(10);
        $d2 = MilliSeconds::createFrom($d1);

        self::assertEquals(10000, $d2->value());

        $d3 = new Seconds(1);
        $d4 = Duration::createFrom($d3);

        self::assertEquals(1e9, $d4->value());
    }

    /**
     * @dataProvider providesTestCompareData
     *
     * @param Duration $lhs
     * @param Duration $rhs
     * @param $result
     */
    public function testCompare(Duration $lhs, Duration $rhs, $result)
    {
        $gotResult = $lhs->compare($rhs);
        switch (true) {
            case $result < 0:
                self::assertLessThan(0, $gotResult);
                break;
            case $result === 0:
                self::assertEquals(0, $gotResult);
                break;
            case $result > 0:
                self::assertGreaterThan(0, $gotResult);
                break;
        }
    }

    public function providesTestGetValueData()
    {
        return [
            [1, Unit::DAYS, 1, Unit::DAYS],
            [1, Unit::HOURS, 1, Unit::HOURS],
            [1, Unit::SECONDS, 1, Unit::SECONDS],
            [1, Unit::MINUTES, 60, Unit::SECONDS],
            [1, Unit::MINUTES, 60e3, Unit::MILLISECONDS],
            [1, Unit::MINUTES, 60e6, Unit::MICROSECONDS],
            [1, Unit::MINUTES, 60e9, Unit::NANOSECONDS],
            [1, Unit::DAYS, 24, Unit::HOURS],

            // One-tenth of a second
            [10, Unit::SECONDS / 10, 1, Unit::SECONDS],
        ];
    }

    public function providesTestGetValueWithOrWithoutUnitData()
    {
        return [
            [new Days(1), 1, Unit::DAYS],
            [new Days(1), 24, Unit::HOURS],
            [new Days(1), 1440, Unit::MINUTES],
            [new Days(1), 86400, Unit::SECONDS],
            [new Days(1), 86400e3, Unit::MILLISECONDS],
            [new Days(1), 86400e6, Unit::MICROSECONDS],
            [new Days(1), 86400e9, Unit::NANOSECONDS],

            [new Hours(24), 1, Unit::DAYS],
            [new Hours(24), 24, Unit::HOURS],
            [new Hours(24), 1440, Unit::MINUTES],
            [new Hours(24), 86400, Unit::SECONDS],
            [new Hours(24), 86400e3, Unit::MILLISECONDS],
            [new Hours(24), 86400e6, Unit::MICROSECONDS],
            [new Hours(24), 86400e9, Unit::NANOSECONDS],

            [new Minutes(1440), 1, Unit::DAYS],
            [new Minutes(1440), 24, Unit::HOURS],
            [new Minutes(1440), 1440, Unit::MINUTES],
            [new Minutes(1440), 86400, Unit::SECONDS],
            [new Minutes(1440), 86400e3, Unit::MILLISECONDS],
            [new Minutes(1440), 86400e6, Unit::MICROSECONDS],
            [new Minutes(1440), 86400e9, Unit::NANOSECONDS],

            [new Seconds(86400), 1, Unit::DAYS],
            [new Seconds(86400), 24, Unit::HOURS],
            [new Seconds(86400), 1440, Unit::MINUTES],
            [new Seconds(86400), 86400, Unit::SECONDS],
            [new Seconds(86400), 86400e3, Unit::MILLISECONDS],
            [new Seconds(86400), 86400e6, Unit::MICROSECONDS],
            [new Seconds(86400), 86400e9, Unit::NANOSECONDS],

            [new MilliSeconds(86400e3), 1, Unit::DAYS],
            [new MilliSeconds(86400e3), 24, Unit::HOURS],
            [new MilliSeconds(86400e3), 1440, Unit::MINUTES],
            [new MilliSeconds(86400e3), 86400, Unit::SECONDS],
            [new MilliSeconds(86400e3), 86400e3, Unit::MILLISECONDS],
            [new MilliSeconds(86400e3), 86400e6, Unit::MICROSECONDS],
            [new MilliSeconds(86400e3), 86400e9, Unit::NANOSECONDS],

            [new MicroSeconds(86400e6), 1, Unit::DAYS],
            [new MicroSeconds(86400e6), 24, Unit::HOURS],
            [new MicroSeconds(86400e6), 1440, Unit::MINUTES],
            [new MicroSeconds(86400e6), 86400, Unit::SECONDS],
            [new MicroSeconds(86400e6), 86400e3, Unit::MILLISECONDS],
            [new MicroSeconds(86400e6), 86400e6, Unit::MICROSECONDS],
            [new MicroSeconds(86400e6), 86400e9, Unit::NANOSECONDS],

            [new NanoSeconds(86400e9), 1, Unit::DAYS],
            [new NanoSeconds(86400e9), 24, Unit::HOURS],
            [new NanoSeconds(86400e9), 1440, Unit::MINUTES],
            [new NanoSeconds(86400e9), 86400, Unit::SECONDS],
            [new NanoSeconds(86400e9), 86400e3, Unit::MILLISECONDS],
            [new NanoSeconds(86400e9), 86400e6, Unit::MICROSECONDS],
            [new NanoSeconds(86400e9), 86400e9, Unit::NANOSECONDS],

            // get value without specifying units will get the value in original units
            [new Days(1), 1, null],
            [new Hours(1), 1, null],
            [new Minutes(1), 1, null],
            [new Seconds(1), 1, null],
            [new MilliSeconds(1), 1, null],
            [new MicroSeconds(1), 1, null],
            [new NanoSeconds(1), 1, null],

            // Can have custom units; here it is one-tenth of a second
            [new Duration(10, Unit::SECONDS / 10), 1, Unit::SECONDS],
        ];
    }

    public function providesTestIsEqual()
    {
        return [
            [new Seconds(10), new MilliSeconds(10000), true],
            [new Seconds(10), new MilliSeconds(10), false],
            [new MilliSeconds(10), new Seconds(10e-3), true],
            [new Days(10), new Hours(240), true],
            [new Seconds(1), new Duration(10, Unit::SECONDS / 10), true],
            [new Seconds(10), new Duration(10, Unit::SECONDS / 10), false],
        ];
    }

    public function providesTestCompareData()
    {
        return [
            [new Seconds(1), new Seconds(10), -1],
            [new Seconds(100), new Seconds(10), 1],
            [new Seconds(1), new Seconds(1), 0],
            [new Seconds(1), new MilliSeconds(1000), 0],
            [new MilliSeconds(1000), new Seconds(1000), -1],
            [new MilliSeconds(1000), new MicroSeconds(1000), 1],
        ];
    }
}
