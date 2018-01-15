<?php

namespace AcoustidApi\ResponseModel;

class Release
{
    /** @var  string */
    protected $id;
    /** @var  string */
    protected $title;
    /** @var  int */
    protected $trackCount;
    /** @var  int */
    protected $mediumCount;
    /** @var  ReleaseEvent[] */
    protected $releaseEvents = [];
    /** @var  string */
    protected $country;
    /** @var  Date */
    protected $date;
    /** @var  Medium[] */
    protected $mediums = [];

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getTrackCount(): int
    {
        return $this->trackCount;
    }

    /**
     * @return int
     */
    public function getMediumCount(): int
    {
        return $this->mediumCount;
    }

    /**
     * @return ReleaseEvent[]
     */
    public function getReleaseEvents(): array
    {
        return $this->releaseEvents;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return Date
     */
    public function getDate(): Date
    {
        return $this->date;
    }

    /**
     * @return Medium[]
     */
    public function getMediums(): array
    {
        return $this->mediums;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param int $trackCount
     */
    public function setTrackCount(int $trackCount): void
    {
        $this->trackCount = $trackCount;
    }

    /**
     * @param int $mediumCount
     */
    public function setMediumCount(int $mediumCount): void
    {
        $this->mediumCount = $mediumCount;
    }

    /**
     * @param ReleaseEvent[] $releaseEvents
     */
    public function setReleaseEvents(array $releaseEvents): void
    {
        $this->releaseEvents = $releaseEvents;
    }

    /**
     * @param ReleaseEvent $releaseEvent
     */
    public function addReleaseEvent(ReleaseEvent $releaseEvent): void
    {
        $this->releaseEvents[] = $releaseEvent;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @param Date $date
     */
    public function setDate(Date $date): void
    {
        $this->date = $date;
    }

    /**
     * @param Medium[] $mediums
     */
    public function setMediums(array $mediums): void
    {
        $this->mediums = $mediums;
    }

    /**
     * @param Medium $medium
     */
    public function addMedium(Medium $medium): void
    {
        $this->mediums[] = $medium;
    }
}
