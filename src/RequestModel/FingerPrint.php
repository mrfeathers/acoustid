<?php

namespace AcoustidApi\RequestModel;


class FingerPrint
{
    /** @var string */
    private $fingerprint;
    /** @var int */
    private $duration;
    /** @var int|null */
    private $birate = null;
    /** @var string|null */
    private $fileformat = null;
    /** @var string|null */
    private $mbid = null;
    /** @var string|null */
    private $track = null;
    /** @var string|null */
    private $artist = null;
    /** @var string|null */
    private $album = null;
    /** @var string|null */
    private $albumartist = null;
    /** @var int|null */
    private $year = null;
    /** @var int|null */
    private $trackno = null;
    /** @var int|null */
    private $discno = null;

    /**
     * FingerPrint constructor.
     *
     * @param string $fingerPrint
     * @param int $duration
     */
    public function __construct(string $fingerPrint, int $duration)
    {
        $this->setFingerprint($fingerPrint)
            ->setDuration($duration);
    }

    /**
     * @return string
     */
    public function getFingerprint(): string
    {
        return $this->fingerprint;
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
    public function getFileformat(): ?string
    {
        return $this->fileformat;
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
    public function getAlbumartist(): ?string
    {
        return $this->albumartist;
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
    public function getTrackno(): ?int
    {
        return $this->trackno;
    }

    /**
     * @return int|null
     */
    public function getDiscno(): ?int
    {
        return $this->discno;
    }

    /**
     * @param string $fingerprint
     *
     * @return FingerPrint
     */
    public function setFingerprint(string $fingerprint): FingerPrint
    {
        $this->fingerprint = $fingerprint;
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
     * @param string $fileformat
     *
     * @return FingerPrint
     */
    public function setFileformat(string $fileformat): FingerPrint
    {
        $this->fileformat = $fileformat;
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
     * @param string $albumartist
     *
     * @return FingerPrint
     */
    public function setAlbumartist(string $albumartist): FingerPrint
    {
        $this->albumartist = $albumartist;
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
     * @param int $trackno
     *
     * @return FingerPrint
     */
    public function setTrackno(int $trackno): FingerPrint
    {
        $this->trackno = $trackno;
        return $this;
    }

    /**
     * @param int $discno
     *
     * @return FingerPrint
     */
    public function setDiscno(int $discno): FingerPrint
    {
        $this->discno = $discno;
        return $this;
    }
}
