<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use DateTimeZone;
use PHPUnit\Framework\TestCase;
use RedMatter\Chrono\Duration\Seconds;

class CalendarTimeTraitTest extends TestCase
{
    /**
     * @dataProvider providesData
     * @requires     PHP 5.5.10
     *
     * @param             $secondsSinceEpoch
     * @param string|null $timezone
     */
    public function testGetDateTime($secondsSinceEpoch, $timezone = null)
    {
        $mock = $this->getMockForTrait('RedMatter\Chrono\Time\CalendarTimeTrait');
        $mock->method('secondsSinceEpoch')
            ->willReturn(new Seconds($secondsSinceEpoch));

        if ($timezone === null) {
            $got = $mock->getDateTime();
            self::assertEquals('+00:00', $got->getTimezone()->getName());
        } else {
            $got = $mock->getDateTime(new DateTimeZone($timezone));
            self::assertEquals($timezone, $got->getTimezone()->getName());
        }

        self::assertEquals($secondsSinceEpoch, $got->format('U.u'), '', 0.05);
    }

    /**
     * @dataProvider providesDataAlt
     *
     * @param             $secondsSinceEpoch
     * @param string|null $timezone
     */
    public function testGetDateTimeAlt($secondsSinceEpoch, $timezone = null)
    {
        // This test is valid only for PHP < 5.5.10
        if (PHP_VERSION_ID >= 50510) {
            self::markTestSkipped();
        }

        $mock = $this->getMockForTrait('RedMatter\Chrono\Time\CalendarTimeTrait');
        $mock->method('secondsSinceEpoch')
            ->willReturn(new Seconds($secondsSinceEpoch));

        if ($timezone === null) {
            $got = $mock->getDateTime();
            self::assertEquals('UTC', $got->getTimezone()->getName());
        } else {
            $got = $mock->getDateTime(new DateTimeZone($timezone));
            self::assertEquals($timezone, $got->getTimezone()->getName());
        }

        self::assertEquals($secondsSinceEpoch, $got->format('U.u'), '', 0.05);
    }

    /**
     * @dataProvider providesData
     *
     * @param $secondsSinceEpoch
     */
    public function testGetUnixTime($secondsSinceEpoch)
    {
        $mock = $this->getMockForTrait('RedMatter\Chrono\Time\CalendarTimeTrait');
        $mock->method('secondsSinceEpoch')
            ->willReturn(new Seconds($secondsSinceEpoch));

        self::assertEquals($secondsSinceEpoch, $mock->getUnixTime(true));
        self::assertEquals(floor($secondsSinceEpoch), $mock->getUnixTime());
    }

    public function providesData()
    {
        return [
            [0],
            [1000],
            [1.1],
            [microtime(true), 'Asia/Kolkata']
        ];
    }

    public function providesDataAlt()
    {
        return [
            [0],
            [1000],
            [1.1],
            [microtime(true), 'Asia/Kolkata']
        ];
    }
}
