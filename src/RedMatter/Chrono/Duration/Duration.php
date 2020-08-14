<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Duration;

use DivisionByZeroError;

/**
 * Models time-duration and facilitates its manipulation and comparison.
 */
class Duration
{
    const UNIT = Unit::UNKNOWN;

    /** @var float */
    protected $value;
    /** @var float */
    protected $unit;

    /**
     * Duration constructor.
     *
     * @param float $value decimal value
     * @param float $unit Unit constant or a custom unit (e.g: Unit::SECONDS / 10 for one-tenth of a second)
     */
    public function __construct($value, $unit)
    {
        $this->value = (float)$value;
        $this->unit = (float)$unit;
    }

    /**
     * Get duration value in given unit. If no unit is given, the object's own unit is assumed.
     *
     * @param float $unit
     *
     * @return float
     */
    public function value($unit = Unit::UNCHANGED)
    {
        if ($unit === Unit::UNCHANGED || $unit === $this->unit) {
            return $this->value;
        }

        return ($this->value * $this->unit) / $unit;
    }

    /**
     * Get integer part of the value.
     *
     * @param float $unit
     *
     * @return int
     */
    public function intValue($unit = Unit::UNCHANGED)
    {
        return (int)$this->value($unit);
    }

    /**
     * Is a zero duration?
     *
     * @return bool
     */
    public function isZero()
    {
        static $zero;
        if ($zero === null) {
            $zero = new NanoSeconds(0);
        }

        return $zero->isEqual($this);
    }

    /**
     * Add durations and return a new object; $this is left unmodified
     *
     * @param Duration $other
     *
     * @return $this
     */
    public function add(Duration $other)
    {
        return new static($this->value + $other->value($this->unit), $this->unit);
    }

    /**
     * Subtract $other from $this and return a new object; $this is left unmodified
     *
     * @param Duration $other
     *
     * @return $this
     */
    public function subtract(Duration $other)
    {
        return new static($this->value - $other->value($this->unit), $this->unit);
    }

    /**
     * Slice $this into $count equal intervals and get one.
     *
     * @param int|float $count
     *
     * @return Duration
     */
    public function slice($count)
    {
        if ((float)$count === 0.0) {
            throw new DivisionByZeroError();
        }

        return new static((float)$this->value / (float)$count, $this->unit);
    }

    /**
     * Get how many time $other can go into $this, in full
     *
     * @param Duration $other
     *
     * @return int
     */
    public function divideInt(Duration $other)
    {
        return (int)$this->divideFloat($other);
    }

    /**
     * Get how many time $other can go into $this
     *
     * @param Duration $other
     *
     * @return float
     */
    public function divideFloat(Duration $other)
    {
        if ($other->isZero()) {
            throw new DivisionByZeroError();
        }

        return (float)($this->value / (float)$other->value($this->unit));
    }

    /**
     * Calculate remainder for dividing $this by $other.
     *
     * @param Duration $other
     *
     * @return static
     */
    public function modulo(Duration $other)
    {
        if ($other->isZero()) {
            throw new DivisionByZeroError();
        }

        // scale up and divide to reduce precision loss
        $thisNano = $this->value(Unit::NANOSECONDS);
        $otherNano = $other->value(Unit::NANOSECONDS);
        $modulo = fmod((float)$thisNano, (float)$otherNano) * Unit::NANOSECONDS / $this->unit;

        return new static($modulo, $this->unit);
    }

    /**
     * Check if $other is equal to this, after normalising the units
     *
     * @param Duration $other
     *
     * @return bool
     */
    public function isEqual(Duration $other)
    {
        return 0 === $this->compare($other);
    }

    /**
     * Use sprintf to convert to decimal value; the default stringification of float would prefer the 'E'
     * format for numbers too big or small. The E format is not compatible with bccomp.
     *
     * @param Duration $duration
     *
     * @return string
     */
    private static function toNanosecondsString(Duration $duration)
    {
        return sprintf("%1.06f", $duration->value(Unit::NANOSECONDS));
    }

    /**
     * Compare $this against $other and return an integer. The return value will be
     * <p>
     *    < 0 if $this is smaller than $other
     * <p>
     *      0 if $this is equal to $other
     * <p>
     *    > 0 if $this is bigger than $other
     *
     * @param Duration $other
     *
     * @return int
     */
    public function compare(Duration $other)
    {
        // In effect we are comparing.
        //   $this->value(Unit::NANOSECONDS)
        //   and
        //   $other->value(Unit::NANOSECONDS)
        //
        // We have to use bccomp since PHP acts strange when comparing float numbers.
        return bccomp(self::toNanosecondsString($this), self::toNanosecondsString($other), 10);
    }

    /**
     * Create one kind of duration from other.
     *
     * @param Duration $other
     *
     * @return Duration|static
     *
     * @example
     * $d1 = new Seconds(10);
     * $d2 = MicroSeconds::createFrom($d1);
     */
    public static function createFrom(Duration $other)
    {
        // if from Duration (directly), then pick nanoseconds as units
        if (static::UNIT === Unit::UNKNOWN) {
            $unit = Unit::NANOSECONDS;
        } else {
            $unit = static::UNIT;
        }

        return new static($other->value($unit), $unit);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (static::UNIT === Unit::UNKNOWN) {
            // see if it matches a standard unit
            $unit = Unit::toString($this->unit, $this->value !== 1.0);
            // if not, we need to make a custom unit
            if ($unit === null) {
                $unit = Unit::customUnitToString($this->unit);
            }
        } else {
            $unit = Unit::toString(static::UNIT, $this->value !== 1.0);
        }

        return "{$this->value} {$unit}";
    }
}
