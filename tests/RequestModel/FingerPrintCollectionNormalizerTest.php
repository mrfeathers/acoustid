<?php

namespace Tests\RequestModel;


use AcoustidApi\RequestModel\FingerPrint;
use AcoustidApi\RequestModel\FingerPrintCollection;
use AcoustidApi\RequestModel\FingerPrintCollectionNormalizer;
use PHPUnit\Framework\TestCase;

class FingerPrintCollectionNormalizerTest extends TestCase
{

    public function testNormalize()
    {
        $normalizer = new FingerPrintCollectionNormalizer();
        $fingerprint1 = new FingerPrint('fingerprint1', 10);
        $fingerprint2 = new FingerPrint('fingerprint2', 20);
        $fingerprint2->setArtist('artistname')
            ->setAlbum('album');
        $expected =[
                    'fingerprint.1' => $fingerprint1->getFingerprint(),
                    'duration.1' => $fingerprint1->getDuration(),
                    'fingerprint.2' => $fingerprint2->getFingerprint(),
                    'duration.2' => $fingerprint2->getDuration(),
                    'artist.2' => $fingerprint2->getArtist(),
                    'album.2' => $fingerprint2->getAlbum(),
                ];
        $collection = new FingerPrintCollection([$fingerprint1, $fingerprint2]);

        $this->assertEquals($expected, $normalizer->normalize($collection));
    }
}
