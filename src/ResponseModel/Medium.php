<?php

namespace AcoustidApi\ResponseModel;

class Medium
{
    /** @var  Track[] */
    protected $tracks = [];
    /** @var  int */
    protected $position;
    /** @var  string */
    protected $format;
    /** @var  int */
    protected $trackCount;
    /** @var  string */
    protected $title;

    /**
     * @return Track[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return int
     */
    public function getTrackCount(): int
    {
        return $this->trackCount;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param Track[] $tracks
     */
    public function setTracks(array $tracks): void
    {
        $this->tracks = $tracks;
    }

    /**
     * @param Track $track
     */
    public function addTrack(Track $track): void
    {
        $this->tracks[] = $track;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    /**
     * @param int $trackCount
     */
    public function setTrackCount(int $trackCount): void
    {
        $this->trackCount = $trackCount;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

}
