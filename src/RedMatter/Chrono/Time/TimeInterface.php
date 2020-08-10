<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Duration\Seconds;

interface TimeInterface
{
    /**
     * Get seconds since epoch
     *
     * @return Seconds
     */
    public function secondsSinceEpoch();

    /**
     * @param Duration $duration
     *
     * @return static
     */
    public function after(Duration $duration);

    /**
     * Get difference between times
     *
     * @param TimeInterface $other
     *
     * @return Duration
     */
    public function diff(TimeInterface $other);

    /**
     * Check if $other time is equal to $this; if they differ in type, it will be false.
     *
     * @param TimeInterface $other
     *
     * @return bool
     */
    public function isEqual(TimeInterface $other);
}
