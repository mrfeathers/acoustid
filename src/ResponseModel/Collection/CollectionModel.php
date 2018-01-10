<?php

namespace AcoustidApi\ResponseModel\Collection;

use Traversable;

abstract class CollectionModel implements \IteratorAggregate
{
    /** @var string */
    private $status;

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getArrayCollection());
    }

    /**
     * Must return class member that represents array collection
     * @return array
     */
    abstract protected function getArrayCollection(): array;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
