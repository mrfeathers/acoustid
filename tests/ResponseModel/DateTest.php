<?php

namespace Tests\ResponseModel;

use AcoustidApi\ResponseModel\Date;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{

    public function testToDateTime()
    {
        $day = 1;
        $month = 2;
        $year = 2000;
        $date = new Date();
        $date->setDay($day);
        $date->setMonth($month);
        $date->setYear($year);

        $dateTime = $date->toDateTime();

        $this->assertEquals($day, $dateTime->format('d'));
        $this->assertEquals($month, $dateTime->format('m'));
        $this->assertEquals($year, $dateTime->format('Y'));
    }
}
