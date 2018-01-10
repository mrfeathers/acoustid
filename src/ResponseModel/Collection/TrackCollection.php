<?php

namespace AcoustidApi\ResponseModel\Collection;

use AcoustidApi\ResponseModel\Track;

class TrackCollection extends CollectionModel
{
    /** @var Track[] */
    private $tracks;

    /**
     * @return Track[]
     */
    public function getTracks(): array
    {
        return $this->tracks;
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
     * Must return class member that represents array collection
     * @return array
     */
    protected function getArrayCollection(): array
    {
        return $this->getTracks();
    }
}
