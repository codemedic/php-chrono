<?php
/**
 * @copyright 2009-2020 Red Matter Ltd (UK)
 */

namespace RedMatter\Chrono\Time;

use DateTime;
use PHPUnit\Framework\TestCase;
use RedMatter\Chrono\Duration\Seconds;

class CalendarTimeTraitTest extends TestCase
{
    /**
     * @dataProvider providesData
     *
     * @param           $secondsSinceEpoch
     * @param DateTime $dateTime
     */
    public function testGetDateTime($secondsSinceEpoch)
    {
        $mock = $this->getMockForTrait('RedMatter\Chrono\Time\CalendarTimeTrait');
        $mock->method('secondsSinceEpoch')
            ->willReturn(new Seconds($secondsSinceEpoch));

        $got = $mock->getDateTime();

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
            [microtime(true)]
        ];
    }
}
