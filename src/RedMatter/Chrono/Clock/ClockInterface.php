<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Clock;

use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Time\TimeInterface;

interface ClockInterface
{
    /**
     * Get current time
     *
     * @return TimeInterface
     */
    public function now();

    /**
     * Post condition: the clock will be advanced by the specified duration
     *
     * @param Duration $duration
     *
     * @return bool false on failure or interruptions
     */
    public function elapse(Duration $duration);
}