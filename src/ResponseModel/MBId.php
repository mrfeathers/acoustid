<?php

namespace AcoustidApi\ResponseModel;

class MBId
{
    /** @var  string */
    protected $mbid;
    /** @var  Track[] */
    protected $tracks = [];

    /**
     * @return string
     */
    public function getMbid(): string
    {
        return $this->mbid;
    }

    /**
     * @return Track[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
    }

    /**
     * @param string $mbid
     */
    public function setMbid(string $mbid): void
    {
        $this->mbid = $mbid;
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
}
