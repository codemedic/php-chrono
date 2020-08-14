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
     * Get time that is after $this by $duration
     *
     * @param Duration $duration
     *
     * @return static
     */
    public function after(Duration $duration);

    /**
     * Get time that is before $this by $duration
     *
     * @param Duration $duration
     *
     * @return static
     */
    public function before(Duration $duration);

    /**
     * Check if $this falls after $other.
     *
     * @param TimeInterface $other
     *
     * @return bool
     */
    public function isAfter(TimeInterface $other);

    /**
     * Check if $this falls before $other.
     *
     * @param TimeInterface $other
     *
     * @return bool
     */
    public function isBefore(TimeInterface $other);

    /**
     * Check if $other time is equal to $this; if they differ in type, it will be false.
     *
     * @param TimeInterface $other
     *
     * @return bool
     */
    public function isEqual(TimeInterface $other);

    /**
     * Get difference between times
     *
     * @param TimeInterface $other
     *
     * @return Duration
     */
    public function diff(TimeInterface $other);
}
