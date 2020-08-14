<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Examples;

use DateTime;
use DateTimeZone;
use RedMatter\Chrono\Clock\CalendarClockInterface;
use RedMatter\Chrono\Duration\Seconds;
use RedMatter\Chrono\Time\CalendarTime;

/**
 * Models a clock that
 * - plays a music at the 0-th minute of every hour
 * - Cuckoos N times at the 0th minute of the N-th hour
 * - Cuckoos once every 15 minutes, except at the 0th minute
 */
class CuckooClock
{
    /** @var CalendarClockInterface */
    private $clock;
    /** @var DateTimeZone */
    private $timeZone;

    public $cuckoo = 0;
    public $music = 0;

    public function __construct(CalendarClockInterface $clock, DateTimeZone $timeZone)
    {
        $this->clock = $clock;
        $this->timeZone = $timeZone;
    }

    public function music()
    {
        $this->music++;
    }

    private function cuckoo()
    {
        $this->cuckoo++;
    }

    private function announceTime(CalendarTime $time)
    {
        list($hours, $minutes, $seconds) = array_map(
            function ($v) {
                return (int)ltrim($v, '0');
            },
            explode(' ', $time->format('h i s', $this->timeZone))
        );

        if ($seconds) {
            return;
        }

        if ($minutes % 15) {
            return;
        }

        // announce every 15 minutes except at 00 minutes
        if ($minutes !== 0) {
            $this->cuckoo();
            return;
        }

        // announce the whole hour
        $this->music();
        while ($hours--) {
            $this->cuckoo();
        }
    }

    public function runUntil(DateTime $until)
    {
        $timeUntil = CalendarTime::fromDateTime($until);
        while (true) {
            $now = $this->clock->now();
            if ($now->isAfter($timeUntil)) {
                break;
            }

            $this->announceTime($now);

            $this->clock->elapse(new Seconds(1.0));
        }
    }
}
