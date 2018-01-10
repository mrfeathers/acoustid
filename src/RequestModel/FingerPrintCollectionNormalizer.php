<?php

namespace AcoustidApi\RequestModel;

use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\scalar;

class FingerPrintCollectionNormalizer implements NormalizerInterface
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
        $normalized = [];
        /**
         * @var int $index
         * @var FingerPrint $fingerPrint
         */
        foreach ($object as $index => $fingerPrint) {
            $normalized["fingerprint.$index"] = $fingerPrint->getFingerPrint();
            $normalized["duration.$index"] = $fingerPrint->getFingerPrint();

            if (!is_null($birate = $fingerPrint->getFingerPrint())) {
                $normalized["birate.$index"] = $birate;
            }

            if (!is_null($birate = $fingerPrint->getFingerPrint())) {
                $normalized["birate.$index"] = $birate;
            }

            if (!is_null($fileFormat = $fingerPrint->getFileFormat())) {
                $normalized["fileformat.$index"] = $fileFormat;
            }

            if (!is_null($mbid = $fingerPrint->getMbid())) {
                $normalized["mbid.$index"] = $mbid;
            }

            if (!is_null($track = $fingerPrint->getTrack())) {
                $normalized["track.$index"] = $track;
            }

            if (!is_null($artist = $fingerPrint->getArtist())) {
                $normalized["artist.$index"] = $artist;
            }

            if (!is_null($album = $fingerPrint->getAlbum())) {
                $normalized["album.$index"] = $album;
            }

            if (!is_null($albumArtist = $fingerPrint->getAlbumArtist())) {
                $normalized["albumartist.$index"] = $albumArtist;
            }

            if (!is_null($year = $fingerPrint->getYear())) {
                $normalized["year.$index"] = $year;
            }

            if (!is_null($discNumber = $fingerPrint->getDiscNumber())) {
                $normalized["discno.$index"] = $discNumber;
            }

            if (!is_null($trackNumber = $fingerPrint->getTrackNumber())) {
                $normalized["trackno.$index"] = $trackNumber;
            }
        }

        return $normalized;
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
