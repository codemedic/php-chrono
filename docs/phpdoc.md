## Table of contents

- [\RedMatter\Chrono\Clock\CalendarClockInterface (interface)](#interface-redmatterchronoclockcalendarclockinterface)
- [\RedMatter\Chrono\Clock\SynchronisedClockInterface (interface)](#interface-redmatterchronoclocksynchronisedclockinterface)
- [\RedMatter\Chrono\Clock\CalendarClock](#class-redmatterchronoclockcalendarclock)
- [\RedMatter\Chrono\Clock\SteadyClock](#class-redmatterchronoclocksteadyclock)
- [\RedMatter\Chrono\Clock\SynchronisedClock](#class-redmatterchronoclocksynchronisedclock)
- [\RedMatter\Chrono\Clock\SteadyClockInterface (interface)](#interface-redmatterchronoclocksteadyclockinterface)
- [\RedMatter\Chrono\Clock\Mock\CalendarClock](#class-redmatterchronoclockmockcalendarclock)
- [\RedMatter\Chrono\Clock\Mock\SteadyClock](#class-redmatterchronoclockmocksteadyclock)
- [\RedMatter\Chrono\Clock\Mock\SynchronisedClock](#class-redmatterchronoclockmocksynchronisedclock)
- [\RedMatter\Chrono\Duration\Days](#class-redmatterchronodurationdays)
- [\RedMatter\Chrono\Duration\Unit](#class-redmatterchronodurationunit)
- [\RedMatter\Chrono\Duration\MilliSeconds](#class-redmatterchronodurationmilliseconds)
- [\RedMatter\Chrono\Duration\NanoSeconds](#class-redmatterchronodurationnanoseconds)
- [\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)
- [\RedMatter\Chrono\Duration\Minutes](#class-redmatterchronodurationminutes)
- [\RedMatter\Chrono\Duration\MicroSeconds](#class-redmatterchronodurationmicroseconds)
- [\RedMatter\Chrono\Duration\Hours](#class-redmatterchronodurationhours)
- [\RedMatter\Chrono\Duration\Seconds](#class-redmatterchronodurationseconds)
- [\RedMatter\Chrono\Time\SteadyTime](#class-redmatterchronotimesteadytime)
- [\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)
- [\RedMatter\Chrono\Time\CalendarTimeInterface (interface)](#interface-redmatterchronotimecalendartimeinterface)
- [\RedMatter\Chrono\Time\TimeInterface (interface)](#interface-redmatterchronotimetimeinterface)

<hr />

<a name="interface-redmatterchronoclockcalendarclockinterface"></a>
### Interface: \RedMatter\Chrono\Clock\CalendarClockInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>elapse(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>bool</em><br /><em>When the function returns, the clock would have elapsed by the specified duration. <p> Returns false on failure or interruptions; otherwise true.</em> |
| public | <strong>now()</strong> : <em>[\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)</em><br /><em>Get current calendar-time. <p> Time readings returned are subject to changes for clock synchronization. Difference between two values obtained after a specific duration need not be the same at all times.</em> |

<hr />

<a name="interface-redmatterchronoclocksynchronisedclockinterface"></a>
### Interface: \RedMatter\Chrono\Clock\SynchronisedClockInterface

> SynchronisedClockInterface is to be used in cases where the logic would rely on both calendar and monotonic clocks.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>elapse(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>bool</em><br /><em>When the function returns, the clock would have elapsed by the specified duration. <p> Returns false on failure or interruptions; otherwise true.</em> |
| public | <strong>getSteadyTime()</strong> : <em>[\RedMatter\Chrono\Time\SteadyTime](#class-redmatterchronotimesteadytime)</em><br /><em>Get time from the embedded SteadyClock.</em> |
| public | <strong>getTime()</strong> : <em>[\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)</em><br /><em>Get time from the embedded Clock.</em> |
| public | <strong>perform(</strong><em>\callable</em> <strong>$f</strong>, <em>\RedMatter\Chrono\Clock\Duration/null</em> <strong>$d=null</strong>)</strong> : <em>mixed</em><br /><em>Perform $f <p> When the function returns, the clock would have elapsed by the duration it took for $f to finish. <p> NOTE: This is meant for time sensitive use cases (from unit-testing perspective) where both the clocks should absolutely be in sync. <p> Returns the return value from $f</em> |

<hr />

<a name="class-redmatterchronoclockcalendarclock"></a>
### Class: \RedMatter\Chrono\Clock\CalendarClock

> Wraps `\microtime` to get calendar time.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>elapse(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>bool</em><br /><em>When the function returns, the clock would have elapsed by the specified duration. <p> Returns false on failure or interruptions; otherwise true.</em> |
| public | <strong>now()</strong> : <em>[\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)</em><br /><em>Get current calendar-time. <p> Time readings returned are subject to changes for clock synchronization. Difference between two values obtained after a specific duration need not be the same at all times.</em> |

*This class implements [\RedMatter\Chrono\Clock\CalendarClockInterface](#interface-redmatterchronoclockcalendarclockinterface)*

<hr />

<a name="class-redmatterchronoclocksteadyclock"></a>
### Class: \RedMatter\Chrono\Clock\SteadyClock

> Wraps `hrtime` to get monotonic time. <p> NOTE: Proper implementation of `\hrtime` is only available in `php >= 7.3`; without it the accuracy of `SteadyClock` will be affected by clock adjustments, either due to NTP sync or manual changes to system time.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>elapse(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>bool</em><br /><em>When the function returns, the clock would have elapsed by the specified duration. <p> Returns false on failure or interruptions; otherwise true.</em> |
| public | <strong>now()</strong> : <em>[\RedMatter\Chrono\Time\SteadyTime](#class-redmatterchronotimesteadytime)</em><br /><em>Get current monotonic-time. <p> When used with PHP 7.3 or later, the time readings returned are free from changes due to clock synchronization. Even though older versions of PHP, which uses `microtime` under the hood, are affected by clock synchronization, it is still the best available option.</em> |

*This class implements [\RedMatter\Chrono\Clock\SteadyClockInterface](#interface-redmatterchronoclocksteadyclockinterface)*

<hr />

<a name="class-redmatterchronoclocksynchronisedclock"></a>
### Class: \RedMatter\Chrono\Clock\SynchronisedClock

> `SynchronisedClock` wraps both calendar-clock and monotonic-clock for use-cases that require both the clocks.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct()</strong> : <em>void</em> |
| public | <strong>elapse(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>bool</em><br /><em>When the function returns, the clock would have elapsed by the specified duration. <p> Returns false on failure or interruptions; otherwise true.</em> |
| public | <strong>getSteadyTime()</strong> : <em>[\RedMatter\Chrono\Time\SteadyTime](#class-redmatterchronotimesteadytime)</em><br /><em>Get time from the embedded SteadyClock.</em> |
| public | <strong>getTime()</strong> : <em>[\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)</em><br /><em>Get time from the embedded Clock.</em> |
| public | <strong>perform(</strong><em>\callable</em> <strong>$f</strong>, <em>\RedMatter\Chrono\Clock\Duration/null</em> <strong>$d=null</strong>)</strong> : <em>mixed</em><br /><em>Perform $f <p> When the function returns, the clock would have elapsed by the duration it took for $f to finish. <p> NOTE: This is meant for time sensitive use cases (from unit-testing perspective) where both the clocks should absolutely be in sync. <p> Returns the return value from $f</em> |

*This class implements [\RedMatter\Chrono\Clock\SynchronisedClockInterface](#interface-redmatterchronoclocksynchronisedclockinterface)*

<hr />

<a name="interface-redmatterchronoclocksteadyclockinterface"></a>
### Interface: \RedMatter\Chrono\Clock\SteadyClockInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>elapse(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>bool</em><br /><em>When the function returns, the clock would have elapsed by the specified duration. <p> Returns false on failure or interruptions; otherwise true.</em> |
| public | <strong>now()</strong> : <em>[\RedMatter\Chrono\Time\SteadyTime](#class-redmatterchronotimesteadytime)</em><br /><em>Get current monotonic-time. <p> When used with PHP 7.3 or later, the time readings returned are free from changes due to clock synchronization. Even though older versions of PHP, which uses `microtime` under the hood, are affected by clock synchronization, it is still the best available option.</em> |

<hr />

<a name="class-redmatterchronoclockmockcalendarclock"></a>
### Class: \RedMatter\Chrono\Clock\Mock\CalendarClock

> Mock Clock that models calendar-clock.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>elapse(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>bool</em> |
| public | <strong>now()</strong> : <em>[\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)</em> |
| public | <strong>setDateTime(</strong><em>[\DateTime](http://php.net/manual/en/class.datetime.php)</em> <strong>$time</strong>)</strong> : <em>void</em><br /><em>Set the time from DateTime</em> |
| public | <strong>setTime(</strong><em>[\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)</em> <strong>$time</strong>)</strong> : <em>void</em><br /><em>Set the time</em> |

*This class implements [\RedMatter\Chrono\Clock\CalendarClockInterface](#interface-redmatterchronoclockcalendarclockinterface)*

<hr />

<a name="class-redmatterchronoclockmocksteadyclock"></a>
### Class: \RedMatter\Chrono\Clock\Mock\SteadyClock

> Mock Clock that models monotonic-clock.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>elapse(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>bool</em> |
| public | <strong>now()</strong> : <em>[\RedMatter\Chrono\Time\SteadyTime](#class-redmatterchronotimesteadytime)</em> |
| public | <strong>setTime(</strong><em>[\RedMatter\Chrono\Time\SteadyTime](#class-redmatterchronotimesteadytime)</em> <strong>$time</strong>)</strong> : <em>void</em><br /><em>Set the time</em> |

*This class implements [\RedMatter\Chrono\Clock\SteadyClockInterface](#interface-redmatterchronoclocksteadyclockinterface)*

<hr />

<a name="class-redmatterchronoclockmocksynchronisedclock"></a>
### Class: \RedMatter\Chrono\Clock\Mock\SynchronisedClock

> A utility class to keep the two clocks in sync.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\RedMatter\Chrono\Clock\Mock\DateTime/null/[\DateTime](http://php.net/manual/en/class.datetime.php)</em> <strong>$startTime=null</strong>)</strong> : <em>void</em><br /><em>Construct clocks, optionally set to a specific time.</em> |
| public | <strong>elapse(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>bool</em> |
| public | <strong>getSteadyTime()</strong> : <em>[\RedMatter\Chrono\Time\SteadyTime](#class-redmatterchronotimesteadytime)</em> |
| public | <strong>getTime()</strong> : <em>[\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)</em> |
| public | <strong>perform(</strong><em>\callable</em> <strong>$f</strong>, <em>\RedMatter\Chrono\Clock\Mock\Duration/null</em> <strong>$d=null</strong>)</strong> : <em>mixed</em> |

*This class implements [\RedMatter\Chrono\Clock\SynchronisedClockInterface](#interface-redmatterchronoclocksynchronisedclockinterface)*

<hr />

<a name="class-redmatterchronodurationdays"></a>
### Class: \RedMatter\Chrono\Duration\Days

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |

*This class extends [\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)*

<hr />

<a name="class-redmatterchronodurationunit"></a>
### Class: \RedMatter\Chrono\Duration\Unit

> Duration unit constants and utilities.

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>customUnitToString(</strong><em>float</em> <strong>$unit</strong>)</strong> : <em>string</em><br /><em>Get string representation for a custom unit. If the unit matches one of the predefined ones, then that will be chosen.</em> |
| public static | <strong>toString(</strong><em>float</em> <strong>$unit</strong>, <em>bool</em> <strong>$plural=false</strong>)</strong> : <em>string/null</em><br /><em>Get unit name from constants; returns null if not a predefined unit</em> |

<hr />

<a name="class-redmatterchronodurationmilliseconds"></a>
### Class: \RedMatter\Chrono\Duration\MilliSeconds

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |

*This class extends [\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)*

<hr />

<a name="class-redmatterchronodurationnanoseconds"></a>
### Class: \RedMatter\Chrono\Duration\NanoSeconds

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |

*This class extends [\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)*

<hr />

<a name="class-redmatterchronodurationduration"></a>
### Class: \RedMatter\Chrono\Duration\Duration

> Models time-duration and facilitates its manipulation and comparison.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>float</em> <strong>$value</strong>, <em>float</em> <strong>$unit</strong>)</strong> : <em>void</em><br /><em>Duration constructor.</em> |
| public | <strong>__toString()</strong> : <em>string</em> |
| public | <strong>add(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$other</strong>)</strong> : <em>\RedMatter\Chrono\Duration\$this</em><br /><em>Add durations and return a new object; $this is left unmodified</em> |
| public | <strong>compare(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$other</strong>)</strong> : <em>int</em><br /><em>Compare $this against $other and return an integer. The return value will be <p> < 0 if $this is smaller than $other <p> 0 if $this is equal to $other <p> > 0 if $this is bigger than $other</em> |
| public static | <strong>createFrom(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$other</strong>)</strong> : <em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)/\RedMatter\Chrono\Duration\static</em><br /><em>Create one kind of duration from other.</em> |
| public | <strong>divideFloat(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$other</strong>)</strong> : <em>float</em><br /><em>Get how many time $other can go into $this</em> |
| public | <strong>divideInt(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$other</strong>)</strong> : <em>int</em><br /><em>Get how many time $other can go into $this, in full</em> |
| public | <strong>intValue(</strong><em>float</em> <strong>$unit=-1</strong>)</strong> : <em>int</em><br /><em>Get integer part of the value.</em> |
| public | <strong>isEqual(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$other</strong>)</strong> : <em>bool</em><br /><em>Check if $other is equal to this, after normalising the units</em> |
| public | <strong>isZero()</strong> : <em>bool</em><br /><em>Is a zero duration?</em> |
| public | <strong>modulo(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$other</strong>)</strong> : <em>\RedMatter\Chrono\Duration\static</em><br /><em>Calculate remainder for dividing $this by $other.</em> |
| public | <strong>slice(</strong><em>int/float</em> <strong>$count</strong>)</strong> : <em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em><br /><em>Slice $this into $count equal intervals and get one.</em> |
| public | <strong>subtract(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$other</strong>)</strong> : <em>\RedMatter\Chrono\Duration\$this</em><br /><em>Subtract $other from $this and return a new object; $this is left unmodified</em> |
| public | <strong>value(</strong><em>float</em> <strong>$unit=-1</strong>)</strong> : <em>float</em><br /><em>Get duration value in given unit. If no unit is given, the object's own unit is assumed.</em> |
###### Examples of Duration::createFrom()
```
$d1 = new Seconds(10);
$d2 = MicroSeconds::createFrom($d1);
```

<hr />

<a name="class-redmatterchronodurationminutes"></a>
### Class: \RedMatter\Chrono\Duration\Minutes

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |

*This class extends [\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)*

<hr />

<a name="class-redmatterchronodurationmicroseconds"></a>
### Class: \RedMatter\Chrono\Duration\MicroSeconds

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |

*This class extends [\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)*

<hr />

<a name="class-redmatterchronodurationhours"></a>
### Class: \RedMatter\Chrono\Duration\Hours

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |

*This class extends [\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)*

<hr />

<a name="class-redmatterchronodurationseconds"></a>
### Class: \RedMatter\Chrono\Duration\Seconds

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$value</strong>)</strong> : <em>void</em> |

*This class extends [\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)*

<hr />

<a name="class-redmatterchronotimesteadytime"></a>
### Class: \RedMatter\Chrono\Time\SteadyTime

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>float</em> <strong>$sinceEpoch</strong>)</strong> : <em>void</em><br /><em>time constructor</em> |
| public | <strong>__toString()</strong> : <em>string</em><br /><em>Convert to string</em> |
| public | <strong>after(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>\RedMatter\Chrono\Time\static</em><br /><em>Get time that is after $this by $duration</em> |
| public | <strong>before(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>\RedMatter\Chrono\Time\static</em><br /><em>Get time that is before $this by $duration</em> |
| public | <strong>diff(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>\RedMatter\Chrono\Time\Duration</em><br /><em>Get difference between times</em> |
| public static | <strong>fromTime(</strong><em>[\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)</em> <strong>$t</strong>)</strong> : <em>[\RedMatter\Chrono\Time\SteadyTime](#class-redmatterchronotimesteadytime)</em><br /><em>Convert calendar-time to monotonic-time. <p> NOTE: Accuracy will be affected by the PHP version; php >= 7.3 preferred</em> |
| public | <strong>isAfter(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>bool</em><br /><em>Check if $this falls after $other.</em> |
| public | <strong>isBefore(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>bool</em><br /><em>Check if $this falls before $other.</em> |
| public | <strong>isEqual(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>bool</em><br /><em>Check if $other time is equal to $this; if they differ in type, it will be false.</em> |
| public | <strong>secondsSinceEpoch()</strong> : <em>[\RedMatter\Chrono\Duration\Seconds](#class-redmatterchronodurationseconds)</em><br /><em>Get seconds since epoch</em> |

*This class implements [\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)*

<hr />

<a name="class-redmatterchronotimecalendartime"></a>
### Class: \RedMatter\Chrono\Time\CalendarTime

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>float</em> <strong>$sinceEpoch</strong>)</strong> : <em>void</em><br /><em>time constructor</em> |
| public | <strong>__toString()</strong> : <em>string</em> |
| public | <strong>after(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>\RedMatter\Chrono\Time\static</em><br /><em>Get time that is after $this by $duration</em> |
| public | <strong>before(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>\RedMatter\Chrono\Time\static</em><br /><em>Get time that is before $this by $duration</em> |
| public | <strong>diff(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>\RedMatter\Chrono\Time\Duration</em><br /><em>Get difference between times</em> |
| public | <strong>format(</strong><em>string</em> <strong>$fmt=`'Y-m-d\TH:i:s.uP'`</strong>, <em>\RedMatter\Chrono\Time\DateTimeZone/null/[\DateTimeZone](http://php.net/manual/en/class.datetimezone.php)</em> <strong>$timeZone=null</strong>)</strong> : <em>string</em><br /><em>Format time using DateTime::format</em> |
| public static | <strong>fromDateTime(</strong><em>[\DateTime](http://php.net/manual/en/class.datetime.php)</em> <strong>$time</strong>)</strong> : <em>[\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)</em><br /><em>Convert DateTime to calendar-time.</em> |
| public static | <strong>fromSteadyTime(</strong><em>[\RedMatter\Chrono\Time\SteadyTime](#class-redmatterchronotimesteadytime)</em> <strong>$t</strong>)</strong> : <em>[\RedMatter\Chrono\Time\CalendarTime](#class-redmatterchronotimecalendartime)</em><br /><em>Convert monotonic-time to calendar-time <p> NOTE: Accuracy will be affected by the PHP version; php >= 7.3 preferred</em> |
| public | <strong>getDateTime(</strong><em>\RedMatter\Chrono\Time\DateTimeZone/null/[\DateTimeZone](http://php.net/manual/en/class.datetimezone.php)</em> <strong>$timeZone=null</strong>)</strong> : <em>\RedMatter\Chrono\Time\DateTime</em><br /><em>Get DateTime If no timezone is specified, it is set to '+00:00'.</em> |
| public | <strong>getUnixTime(</strong><em>bool</em> <strong>$float=false</strong>)</strong> : <em>int/float</em><br /><em>Get unixtime</em> |
| public | <strong>isAfter(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>bool</em><br /><em>Check if $this falls after $other.</em> |
| public | <strong>isBefore(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>bool</em><br /><em>Check if $this falls before $other.</em> |
| public | <strong>isEqual(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>bool</em><br /><em>Check if $other time is equal to $this; if they differ in type, it will be false.</em> |
| public | <strong>secondsSinceEpoch()</strong> : <em>[\RedMatter\Chrono\Duration\Seconds](#class-redmatterchronodurationseconds)</em><br /><em>Get seconds since epoch</em> |

*This class implements [\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface), [\RedMatter\Chrono\Time\CalendarTimeInterface](#interface-redmatterchronotimecalendartimeinterface)*

<hr />

<a name="interface-redmatterchronotimecalendartimeinterface"></a>
### Interface: \RedMatter\Chrono\Time\CalendarTimeInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getDateTime(</strong><em>\RedMatter\Chrono\Time\DateTimeZone/null/[\DateTimeZone](http://php.net/manual/en/class.datetimezone.php)</em> <strong>$timeZone=null</strong>)</strong> : <em>\RedMatter\Chrono\Time\DateTime</em><br /><em>Get DateTime If no timezone is specified, it is set to '+00:00'.</em> |
| public | <strong>getUnixTime(</strong><em>bool</em> <strong>$float=false</strong>)</strong> : <em>int/float</em><br /><em>Get unixtime</em> |

<hr />

<a name="interface-redmatterchronotimetimeinterface"></a>
### Interface: \RedMatter\Chrono\Time\TimeInterface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>after(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>\RedMatter\Chrono\Time\static</em><br /><em>Get time that is after $this by $duration</em> |
| public | <strong>before(</strong><em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em> <strong>$duration</strong>)</strong> : <em>\RedMatter\Chrono\Time\static</em><br /><em>Get time that is before $this by $duration</em> |
| public | <strong>diff(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>[\RedMatter\Chrono\Duration\Duration](#class-redmatterchronodurationduration)</em><br /><em>Get difference between times</em> |
| public | <strong>isAfter(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>bool</em><br /><em>Check if $this falls after $other.</em> |
| public | <strong>isBefore(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>bool</em><br /><em>Check if $this falls before $other.</em> |
| public | <strong>isEqual(</strong><em>[\RedMatter\Chrono\Time\TimeInterface](#interface-redmatterchronotimetimeinterface)</em> <strong>$other</strong>)</strong> : <em>bool</em><br /><em>Check if $other time is equal to $this; if they differ in type, it will be false.</em> |
| public | <strong>secondsSinceEpoch()</strong> : <em>[\RedMatter\Chrono\Duration\Seconds](#class-redmatterchronodurationseconds)</em><br /><em>Get seconds since epoch</em> |

