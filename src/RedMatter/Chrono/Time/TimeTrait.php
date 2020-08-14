<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use InvalidArgumentException;
use RedMatter\Chrono\Duration\Duration;
use RedMatter\Chrono\Duration\Seconds;

trait TimeTrait
{
    /** @var Seconds */
    private $sinceEpoch;

    /**
     * time constructor
     *
     * @param float $sinceEpoch duration since epoch as fractional seconds
     */
    public function __construct($sinceEpoch)
    {
        $this->sinceEpoch = new Seconds($sinceEpoch);
    }

    /**
     * @inheritDoc
     */
    public function secondsSinceEpoch()
    {
        return $this->sinceEpoch;
    }

    /**
     * Get difference between times
     *
     * @param TimeInterface $other
     *
     * @return Duration
     */
    public function diff(TimeInterface $other)
    {
        if (!$other instanceof static) {
            throw new InvalidArgumentException("Argument must be of type " . get_class($this));
        }

        return $this->sinceEpoch
            ->subtract($other->sinceEpoch);
    }

    /**
     * @inheritDoc
     */
    public function after(Duration $duration)
    {
        $ret = clone $this;
        $ret->sinceEpoch = $this->sinceEpoch->add($duration);

        return $ret;
    }

    /**
     * @inheritDoc
     */
    public function before(Duration $duration)
    {
        $ret = clone $this;
        $ret->sinceEpoch = $this->sinceEpoch->subtract($duration);

        return $ret;
    }

    /**
     * @inheritDoc
     */
    public function isAfter(TimeInterface $other)
    {
        if (!$other instanceof static) {
            return false;
        }

        return 1 === $this->secondsSinceEpoch()
                ->compare(
                    $other->secondsSinceEpoch()
                );
    }

    /**
     * @inheritDoc
     */
    public function isBefore(TimeInterface $other)
    {
        if (!$other instanceof static) {
            return false;
        }

        return -1 === $this->secondsSinceEpoch()
                ->compare(
                    $other->secondsSinceEpoch()
                );
    }

    /**
     * @inheritDoc
     */
    public function isEqual(TimeInterface $other)
    {
        if (!$other instanceof static) {
            return false;
        }

        return $this->secondsSinceEpoch()
            ->isEqual($other->secondsSinceEpoch());
    }
}
