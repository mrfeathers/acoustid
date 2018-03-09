<?php

namespace AcoustidApi\ResponseModel\Collection;

use AcoustidApi\ResponseModel\MBId;

class MBIdCollection extends CollectionModel
{
    /** @var MBId[] */
    private $mbids = [];

    /**
     * @return MBId[]
     */
    public function getMbids(): array
    {
        return $this->mbids;
    }

    /**
     * @param MBId[] $mbids
     */
    public function setMbids(array $mbids): void
    {
        $this->mbids = $mbids;
    }

    /**
     * @param MBId $mbid
     */
    public function addMbid(MBId $mbid): void
    {
        $this->mbids[] = $mbid;
    }

    /**
     * Must return class member that represents array collection
     * @return array
     */
    protected function getArrayCollection(): array
    {
        return $this->getMbids();
    }
}
