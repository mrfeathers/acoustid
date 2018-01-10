<?php

namespace AcoustidApi\ResponseModel;

class Result
{
    /** @var  string */
    protected $id;
    /** @var  float */
    protected $score;
    /** @var  Recording[] */
    protected $recordings = [];

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
     * @return Recording[]
     */
    public function getRecordings(): array
    {
        return $this->recordings;
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
     * @param Recording[] $recordings
     */
    public function setRecordings(array $recordings): void
    {
        $this->recordings = $recordings;
    }

    /**
     * @param Recording $recording
     */
    public function addRecording(Recording $recording): void
    {
        $this->recordings[] = $recording;
    }
}
