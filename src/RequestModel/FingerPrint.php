<?php

namespace AcoustidApi\RequestModel;


class FingerPrint
{
    /** @var string */
    private $fingerPrint;
    /** @var int */
    private $duration;
    /** @var int|null */
    private $birate = null;
    /** @var string|null */
    private $fileFormat = null;
    /** @var string|null */
    private $mbid = null;
    /** @var string|null */
    private $track = null;
    /** @var string|null */
    private $artist = null;
    /** @var string|null */
    private $album = null;
    /** @var string|null */
    private $albumArtist = null;
    /** @var int|null */
    private $year = null;
    /** @var int|null */
    private $trackNumber = null;
    /** @var int|null */
    private $discNumber = null;

    /**
     * FingerPrint constructor.
     *
     * @param string $fingerPrint
     * @param int $duration
     */
    public function __construct(string $fingerPrint, int $duration)
    {
        $this->setFingerPrint($fingerPrint)
            ->setDuration($duration);
    }

    /**
     * @return string
     */
    public function getFingerPrint(): string
    {
        return $this->fingerPrint;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return int|null
     */
    public function getBirate(): ?int
    {
        return $this->birate;
    }

    /**
     * @return string|null
     */
    public function getFileFormat(): ?string
    {
        return $this->fileFormat;
    }

    /**
     * @return string|null
     */
    public function getMbid(): ?string
    {
        return $this->mbid;
    }

    /**
     * @return string|null
     */
    public function getTrack(): ?string
    {
        return $this->track;
    }

    /**
     * @return string|null
     */
    public function getArtist(): ?string
    {
        return $this->artist;
    }

    /**
     * @return string|null
     */
    public function getAlbum(): ?string
    {
        return $this->album;
    }

    /**
     * @return string|null
     */
    public function getAlbumArtist(): ?string
    {
        return $this->albumArtist;
    }

    /**
     * @return int|null
     */
    public function getYear(): ?int
    {
        return $this->year;
    }

    /**
     * @return int|null
     */
    public function getTrackNumber(): ?int
    {
        return $this->trackNumber;
    }

    /**
     * @return int|null
     */
    public function getDiscNumber(): ?int
    {
        return $this->discNumber;
    }

    /**
     * @param string $fingerPrint
     *
     * @return FingerPrint
     */
    public function setFingerPrint(string $fingerPrint): FingerPrint
    {
        $this->fingerPrint = $fingerPrint;
        return $this;
    }

    /**
     * @param int $duration
     *
     * @return FingerPrint
     */
    public function setDuration(int $duration): FingerPrint
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * @param int $birate
     *
     * @return FingerPrint
     */
    public function setBirate(int $birate): FingerPrint
    {
        $this->birate = $birate;
        return $this;
    }

    /**
     * @param string $fileFormat
     *
     * @return FingerPrint
     */
    public function setFileFormat(string $fileFormat): FingerPrint
    {
        $this->fileFormat = $fileFormat;
        return $this;
    }

    /**
     * @param string $mbid
     *
     * @return FingerPrint
     */
    public function setMbid(string $mbid): FingerPrint
    {
        $this->mbid = $mbid;
        return $this;
    }

    /**
     * @param string $track
     *
     * @return FingerPrint
     */
    public function setTrack(string $track): FingerPrint
    {
        $this->track = $track;
        return $this;
    }

    /**
     * @param string $artist
     *
     * @return FingerPrint
     */
    public function setArtist(string $artist): FingerPrint
    {
        $this->artist = $artist;
        return $this;
    }

    /**
     * @param string $album
     *
     * @return FingerPrint
     */
    public function setAlbum(string $album): FingerPrint
    {
        $this->album = $album;
        return $this;
    }

    /**
     * @param string $albumArtist
     *
     * @return FingerPrint
     */
    public function setAlbumArtist(string $albumArtist): FingerPrint
    {
        $this->albumArtist = $albumArtist;
        return $this;
    }

    /**
     * @param int $year
     *
     * @return FingerPrint
     */
    public function setYear(int $year): FingerPrint
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @param int $trackNumber
     *
     * @return FingerPrint
     */
    public function setTrackNumber(int $trackNumber): FingerPrint
    {
        $this->trackNumber = $trackNumber;
        return $this;
    }

    /**
     * @param int $discNumber
     *
     * @return FingerPrint
     */
    public function setDiscNumber(int $discNumber): FingerPrint
    {
        $this->discNumber = $discNumber;
        return $this;
    }

}
