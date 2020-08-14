<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock\Mock;

use DateTime;
use PHPUnit\Framework\TestCase;
use RedMatter\Chrono\Duration\MilliSeconds;
use RedMatter\Chrono\Duration\Unit;

class SynchronisedClocksTest extends TestCase
{
    public function testConstructor()
    {
        $now = new DateTime('now');
        $sc1 = new SynchronisedClock();
        $t1 = $sc1->getTime();
        $st1 = $sc1->getSteadyTime();

        $sc2 = new SynchronisedClock($now);
        $t2 = $sc2->getTime();
        $st2 = $sc2->getSteadyTime();

        self::assertFalse($t2->isEqual($t1));
        self::assertEquals($now, $t2->getDateTime());

        // steady time does not change
        self::assertEquals($st1, $st2);
    }

    public function testElapse()
    {
        $sc = new SynchronisedClock();
        $t1 = $sc->getTime();
        $st1 = $sc->getSteadyTime();

        $sc->elapse(new MilliSeconds(100));

        $t2 = $sc->getTime();
        $st2 = $sc->getSteadyTime();

        self::assertEquals($st2->diff($st1), $t2->diff($t1));
        self::assertTrue($st2->diff($st1)->isEqual(new MilliSeconds(100)));
    }

    public function testMockPerform()
    {
        $nanoSleep = 0.2 * 1e9;
        $f = function () use ($nanoSleep) {
            time_nanosleep(0, $nanoSleep);
        };

        $sc = new SynchronisedClock();
        $sc->perform($f);
        $t1 = $sc->getTime();
        $st1 = $sc->getSteadyTime();
        $sc->perform($f, $d);
        $t2 = $sc->getTime();
        $st2 = $sc->getSteadyTime();

        self::assertGreaterThan($nanoSleep, $d->value(Unit::NANOSECONDS));
        self::assertGreaterThan($nanoSleep, $t2->diff($t1)->value(Unit::NANOSECONDS));
        self::assertGreaterThan($nanoSleep, $st2->diff($st1)->value(Unit::NANOSECONDS));
    }

    public function testRealPerform()
    {
        $nanoSleep = 0.2 * 1e9;
        $f = function () use ($nanoSleep) {
            time_nanosleep(0, $nanoSleep);
        };

        $realSc = new \RedMatter\Chrono\Clock\SynchronisedClock();
        $realSc->perform($f);
        $t1 = $realSc->getTime();
        $st1 = $realSc->getSteadyTime();
        $realSc->perform($f, $d);
        $t2 = $realSc->getTime();
        $st2 = $realSc->getSteadyTime();

        self::assertGreaterThan($nanoSleep, $d->value(Unit::NANOSECONDS));
        self::assertGreaterThan($nanoSleep, $t2->diff($t1)->value(Unit::NANOSECONDS));
        self::assertGreaterThan($nanoSleep, $st2->diff($st1)->value(Unit::NANOSECONDS));
    }
}
