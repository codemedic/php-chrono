<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use DateTime;
use DateTimeZone;

interface CalendarTimeInterface extends TimeInterface
{
    /**
     * Get DateTime
     *
     * @param DateTimeZone|null $timeZone
     *
     * @return DateTime
     */
    public function getDateTime(DateTimeZone $timeZone = null);

    /**
     * Get unixtime
     *
     * @param bool $float
     *
     * @return int|float
     */
    public function getUnixTime($float = false);
}
