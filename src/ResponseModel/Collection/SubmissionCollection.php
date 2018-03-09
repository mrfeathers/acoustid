<?php

namespace AcoustidApi\ResponseModel\Collection;

use AcoustidApi\ResponseModel\Submission;

class SubmissionCollection extends CollectionModel
{

    /** @var Submission[] */
    private $submissions = [];

    /**
     * @return Submission[]
     */
    public function getSubmissions(): array
    {
        return $this->submissions;
    }

    /**
     * @param Submission[] $submissions
     */
    public function setSubmissions(array $submissions): void
    {
        $this->submissions = $submissions;
    }

    /**
     * @param Submission $submission
     */
    public function addSubmission(Submission $submission): void
    {
        $this->submissions[] = $submission;
    }

    /**
     * Must return class member that represents array collection
     * @return array
     */
    protected function getArrayCollection(): array
    {
        return $this->getSubmissions();
    }
}
