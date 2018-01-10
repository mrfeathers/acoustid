<?php

namespace AcoustidApi\ResponseModel;

class Recording
{
    /** @var  string */
    protected $id;
    /** @var  float */
    protected $score;
    /** @var  int */
    protected $sources;
    /** @var  string */
    protected $title;
    /** @var  float */
    protected $duration;
    /** @var  Artist[] */
    protected $artists = [];
    /** @var  ReleaseGroup[] */
    protected $releaseGroups = [];
    /** @var  Release[] */
    protected $releases = [];

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getScore(): float
    {
        return $this->score;
    }

    /**
     * @return int
     */
    public function getSources(): int
    {
        return $this->sources;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * @return Artist[]
     */
    public function getArtists(): array
    {
        return $this->artists;
    }

    /**
     * @return ReleaseGroup[]
     */
    public function getReleaseGroups(): array
    {
        return $this->releaseGroups;
    }

    /**
     * @return Release[]
     */
    public function getReleases(): array
    {
        return $this->releases;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param float $score
     */
    public function setScore(float $score): void
    {
        $this->score = $score;
    }

    /**
     * @param int $sources
     */
    public function setSources(int $sources): void
    {
        $this->sources = $sources;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param float $duration
     */
    public function setDuration(float $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @param array $artists
     */
    public function setArtists(array $artists): void
    {
        $this->artists = $artists;
    }

    /**
     * @param Artist $artist
     */
    public function addArtist(Artist $artist): void
    {
        $this->artists[] = $artist;
    }


    /**
     * @param ReleaseGroup[] $releaseGroups
     */
    public function setReleaseGroups(array $releaseGroups): void
    {
        $this->releaseGroups = $releaseGroups;
    }

    /**
     * @param ReleaseGroup $releaseGroup
     */
    public function addReleaseGroup(ReleaseGroup $releaseGroup): void
    {
        $this->releaseGroups[] = $releaseGroup;
    }

    /**
     * @param Release[] $releases
     */
    public function setReleases(array $releases): void
    {
        $this->releases = $releases;
    }

    /**
     * @param Release $release
     */
    public function addRelease(Release $release): void
    {
        $this->releases[] = $release;
    }

    /**
     * @return bool
     */
    public function hasArtists(): bool
    {
        return empty($this->artists);
    }


    public function __toString()
    {
        $string = "Title: ".$this->title;
        if ($this->hasArtists()) {
            $string .= "\nArtists: ";
            foreach ($this->artists as $artist) {
                $string .= $artist->getName() . "\n";
            }
        }
        return $string;
    }
}
