<?php

namespace AcoustidApi\ResponseModel;

class ReleaseGroup
{
    /** @var  string */
    protected $id;
    /** @var  string */
    protected $type = '';
    /** @var  Artist[] */
    protected $artists = [];
    /** @var  string */
    protected $title;
    /** @var  Release[] */
    protected $releases = [];
    /** @var  array */
    protected $secondaryTypes = [];

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
    public function getType(): string 
    {
        return $this->type;
    }

    /**
     * @return Artist[]
     */
    public function getArtists(): array 
    {
        return $this->artists;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getReleases(): array 
    {
        return $this->releases;
    }

    /**
     * @return array
     */
    public function getSecondaryTypes(): array 
    {
        return $this->secondaryTypes;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param Artist[] $artists
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
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
     * @param array $secondaryTypes
     */
    public function setSecondaryTypes(array $secondaryTypes): void
    {
        $this->secondaryTypes = $secondaryTypes;
    }
    
}
