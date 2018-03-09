<?php

namespace AcoustidApi\ResponseModel;


class ReleaseEvent
{
    /** @var  string */
    protected $country = '';
    /** @var  Date */
    protected $date = null;

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return Date|null
     */
    public function getDate(): ?Date
    {
        return $this->date;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @param Date|null $date
     */
    public function setDate(?Date $date): void
    {
        $this->date = $date;
    }

}
