<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use DateTime;
use DateTimeZone;
use RedMatter\Chrono\Duration\Seconds;
use RuntimeException;

trait CalendarTimeTrait
{
    /**
     * @inheritDoc
     *
     * @return Seconds
     */
    abstract public function secondsSinceEpoch();

    /**
     * @inheritDoc
     */
    public function getDateTime(DateTimeZone $timeZone = null)
    {
        static $defaultTz;

        $sinceEpoch = $this->secondsSinceEpoch();
        // ensure decimal number
        $strSinceEpoch = sprintf('%0.6f', $sinceEpoch->value());
        $ret = DateTime::createFromFormat('U.u', $strSinceEpoch);
        if ($ret === false) {
            throw new RuntimeException("Failed to convert to DateTime");
        }

        // explicitly set the default behaviour
        if ($timeZone === null) {
            if (!$defaultTz) {
                $defaultTz = new DateTimeZone('+00:00');
            }

            $timeZone = $defaultTz;
        }

        $ret->setTimezone($timeZone);

        return $ret;
    }

    /**
     * @inheritDoc
     */
    public function getUnixTime($float = false)
    {
        $sinceEpoch = $this->secondsSinceEpoch();
        if ($float) {
            return $sinceEpoch->value();
        }

        return $sinceEpoch->intValue();
    }
}
