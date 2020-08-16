<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use DateTime;
use DateTimeZone;
use RuntimeException;

interface CalendarTimeInterface
{
    /**
     * Get DateTime
     * <p>
     * If no timezone is specified, it is set to '+00:00' except for PHP < 5.5.10. For PHP < 5.5.10 it is set to 'UTC'.
     *
     * @param DateTimeZone|null $timeZone
     *
     * @return DateTime
     * @throws RuntimeException
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
