<?php

namespace AcoustidApi\ResponseModel;

use DateTime;

class Date
{
    /** @var int */
    private $day = 0;
    /** @var int */
    private $month = 0;
    /** @var int */
    private $year = 0;

    /**
     * @return int
     */
    public function getDay(): int
    {
        return $this->day;
    }

    /**
     * @param int $day
     */
    public function setDay(int $day): void
    {
        $this->day = $day;
    }

    /**
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * @param int $month
     */
    public function setMonth(int $month): void
    {
        $this->month = $month;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    /**
     * @return DateTime
     */
    public function toDateTime(): DateTime
    {
        return new DateTime("{$this->day}-{$this->month}-{$this->year} 00:00:00");
    }
}
