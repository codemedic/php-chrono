<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock\Mock;

use DateTime;
use RedMatter\Chrono\Clock\SynchronisedClockInterface;
use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Time\SteadyTime;
use RedMatter\Chrono\Time\Time;

/**
 * A utility class to keep the two clocks in sync.
 */
class SynchronisedClock implements SynchronisedClockInterface
{
    /** @var Clock */
    private $mockClock;
    /** @var SteadyClock */
    private $mockSteadyClock;

    /**
     * Construct clocks, optionally set to a specific time.
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
     * @see \RedMatter\Chrono\Clock\SynchronisedClockInterface::getSteadyTime()
     *
     * @return SteadyTime
     */
    public function getSteadyTime()
    {
        return $this->mockSteadyClock->now();
    }

    /**
     * @see \RedMatter\Chrono\Clock\SynchronisedClockInterface::getTime()
     *
     * @return Time
     */
    public function getTime()
    {
        return $this->mockClock->now();
    }

    /**
     * @see \RedMatter\Chrono\Clock\SynchronisedClockInterface::elapse()
     * <p>
     * NOTE: The mock version would always return true.
     *
     * @param Duration $duration
     *
     * @return bool
     */
    public function elapse(Duration $duration)
    {
        $this->mockClock->elapse($duration);
        $this->mockSteadyClock->elapse($duration);

        return true;
    }

    /**
     * @see \RedMatter\Chrono\Clock\SynchronisedClockInterface::perform()
     *
     * @param callable $f
     * @param Duration|null $d
     *
     * @return mixed
     */
    public function perform(callable $f, Duration &$d = null)
    {
        $clock = new \RedMatter\Chrono\Clock\SteadyClock();
        $startTime = $clock->now();

        $ret = $f();

        $d = $clock->now()->diff($startTime);

        $this->elapse($d);

        return $ret;
    }
}
