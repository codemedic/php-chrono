<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Examples;

use DateInterval;
use DateTime;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use RedMatter\Chrono\Clock\Mock\Clock as MockClock;

class CuckooClockTest extends TestCase
{
    public function testCuckoo()
    {
        $now = DateTime::createFromFormat(DateTime::ATOM, '2003-11-12T01:01:00+00:00');

        $twoHoursFromNow = clone $now;
        $twoHoursFromNow->add(DateInterval::createFromDateString('2 hours'));

        $clock = new MockClock();
        $clock->setDateTime($now);

        $cuckooClock = new CuckooClock($clock, new DateTimeZone('Asia/Kolkata'));
        $cuckooClock->runUntil($twoHoursFromNow);

        self::assertEquals(2, $cuckooClock->music);
        self::assertEquals(21, $cuckooClock->cuckoo);
    }
}
