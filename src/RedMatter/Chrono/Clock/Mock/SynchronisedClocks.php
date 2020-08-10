<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock\Mock;

use DateTime;
use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Time\SteadyTime;
use RedMatter\Chrono\Time\Time;

/**
 * A utility class to keep the two clocks in sync.
 */
class SynchronisedClocks
{
    /** @var Clock */
    private $mockClock;
    /** @var SteadyClock */
    private $mockSteadyClock;

    /**
     * Construct clocks synchronised to NOW. It adjusts the wall-clock to the specified startTime.
     *
     * @param DateTime|null $startTime
     */
    public function __construct(DateTime $startTime = null)
    {
        $this->mockClock = new Clock();
        $this->mockSteadyClock = new SteadyClock();

        if ($startTime !== null) {
            // synchronise the clocks based on startTime
            $this->mockClock->setDateTime($startTime);
        }
    }

    /**
     * Synchronise the steady-clock to wall-clock. Use this in combination with startTime argument for the constructor.
     *
     * NOTE: Accuracy will be affected by the PHP version; php >= 7.3 preferred
     */
    public function syncSteadyClock()
    {
        $now = $this->mockClock->now();
        $this->mockSteadyClock->setTime(
            SteadyTime::fromTime($now)
        );
    }

    /**
     * Get time from the steady-clock
     *
     * @return SteadyTime
     */
    public function getSteadyTime()
    {
        return $this->mockSteadyClock->now();
    }

    /**
     * Get time from the wall-clock
     *
     * @return Time
     */
    public function getTime()
    {
        return $this->mockClock->now();
    }

    /**
     * Elapse the two clocks by specified duration
     *
     * @param Duration $duration
     */
    public function elapse(Duration $duration)
    {
        $this->mockClock->elapse($duration);
        $this->mockSteadyClock->elapse($duration);
    }

    /**
     * Perform f and adjust both clocks by the time it took to perform it.
     *
     * NOTE: Accuracy will be affected by the PHP version; php >= 7.3 preferred
     *
     * @param callable $f
     */
    public function perform(callable $f)
    {
        $clock = new SteadyClock();
        $startTime = $clock->now();

        $f();

        $this->elapse($clock->now()->diff($startTime));
    }
}
