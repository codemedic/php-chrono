<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use DateTime;
use DateTimeZone;
use Exception;
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

        // explicitly set the default behaviour
        if ($timeZone === null) {
            if (!$defaultTz) {
                try {
                    $defaultTz = new DateTimeZone('+00:00');
                } catch (Exception $e) {
                    $defaultTz = new DateTimeZone('UTC');
                }
            }

            $timeZone = $defaultTz;
        }

        $sinceEpoch = $this->secondsSinceEpoch();
        // ensure decimal number
        $strSinceEpoch = sprintf('%0.6f', $sinceEpoch->value());
        try {
            $ret = DateTime::createFromFormat('U.u', $strSinceEpoch, $timeZone);
            if ($ret === false) {
                $ret = new DateTime('@' . (int)$strSinceEpoch, $timeZone);
            }
        } catch (Exception $e) {
            throw new RuntimeException("Failed to convert to DateTime", 0, $e);
        }

        // workaround for ignored $timeZone when parsing UnixTime
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
