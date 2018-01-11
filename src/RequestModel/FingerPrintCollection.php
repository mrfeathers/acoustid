<?php

namespace AcoustidApi\RequestModel;

use Traversable;

class FingerPrintCollection implements \IteratorAggregate
{
    /** @var FingerPrint[] */
    private $fingerPrints;

    public function __construct(array $fingerPrints)
    {
        $this->fingerPrints = $fingerPrints;
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->fingerPrints);
    }

    /**
     * @return FingerPrint[]|array
     */
    public function getFingerPrints(): array
    {
        return $this->fingerPrints;
    }

    /**
     * @param FingerPrint $fingerPrint
     */
    public function addFingerPrint(FingerPrint $fingerPrint): void
    {
        $this->fingerPrints[] = $fingerPrint;
    }
}
