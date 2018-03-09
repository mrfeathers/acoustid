<?php

namespace AcoustidApi\ResponseModel\Collection;

use AcoustidApi\ResponseModel\Result;

class ResultCollection extends CollectionModel
{

    /** @var Result[] */
    private $results = [];

    /**
     * @return array
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param array $results
     */
    public function setResults(array $results): void
    {
        $this->results = $results;
    }

    /**
     * @param Result $result
     */
    public function addResult(Result $result): void
    {
        $this->results[] = $result;
    }

    /**
     * Must return class member that represents array collection
     * @return array
     */
    protected function getArrayCollection(): array
    {
        return $this->getResults();
    }
}
