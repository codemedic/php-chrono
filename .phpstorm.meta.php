<?php

namespace PHPSTORM_META {
    registerArgumentsSet('redmatter_chrono_duration_units',
        \RedMatter\Chrono\Duration\Unit::NANOSECONDS,
        \RedMatter\Chrono\Duration\Unit::MICROSECONDS,
        \RedMatter\Chrono\Duration\Unit::MILLISECONDS,
        \RedMatter\Chrono\Duration\Unit::SECONDS,
        \RedMatter\Chrono\Duration\Unit::MINUTES,
        \RedMatter\Chrono\Duration\Unit::HOURS,
        \RedMatter\Chrono\Duration\Unit::DAYS
    );

    registerArgumentsSet('redmatter_chrono_time_format',
        DATE_ATOM,
        DATE_COOKIE,
        DATE_ISO8601,
        DATE_RFC822,
        DATE_RFC850,
        DATE_RFC1036,
        DATE_RFC1123,
        DATE_RFC2822,
        DATE_RFC3339,
        DATE_RFC3339_EXTENDED,
        DATE_RFC7231,
        DATE_RSS,
        DATE_W3C,
        \RedMatter\Chrono\Time\CalendarTime::DEFAULT_FORMAT
    );

    expectedArguments(
        \RedMatter\Chrono\Duration\Duration::__construct(),
        1,
        argumentsSet('redmatter_chrono_duration_units')
    );

    expectedArguments(
        \RedMatter\Chrono\Duration\Duration::value(),
        0,
        argumentsSet('redmatter_chrono_duration_units')
    );

    expectedArguments(
        \RedMatter\Chrono\Duration\Duration::intValue(),
        0,
        argumentsSet('redmatter_chrono_duration_units')
    );

    expectedArguments(
        \RedMatter\Chrono\Time\CalendarTime::format(),
        0,
        argumentsSet("redmatter_chrono_time_format")
    );

    expectedArguments(
        \RedMatter\Chrono\Duration\Unit::toString(),
        0,
        argumentsSet("redmatter_chrono_duration_units")
    );

    expectedArguments(
        \RedMatter\Chrono\Duration\Unit::customUnitToString(),
        0,
        argumentsSet("redmatter_chrono_duration_units")
    );
}