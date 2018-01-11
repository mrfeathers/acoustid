<?php

namespace AcoustidApi\RequestModel;

use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\scalar;

class FingerPrintCollectionNormalizer extends ObjectNormalizer
{

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param object $object Object to normalize
     * @param string $format Format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|scalar
     *
     * @throws InvalidArgumentException   Occurs when the object given is not an attempted type for the normalizer
     * @throws CircularReferenceException Occurs when the normalizer detects a circular reference when no circular
     *                                    reference handler can fix it
     * @throws LogicException             Occurs when the normalizer is not called in an expected context
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $normalized = array_map(function($fingerPrint) {
            return parent::normalize($fingerPrint);
        }, $object->getFingerPrints());

        $result = [];
        foreach ($normalized as $index => $fingerprint) {
            foreach ($fingerprint as $key => $value) {
                if ($value !== null) {
                    $newKey = sprintf("%s.%s", $key, $index + 1);
                    $result[$newKey] = $value;
                }
            }
        }

        return $result;
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof FingerPrintCollection;
    }
}
