<?php
namespace Application\Sonata\MediaBundle\Provider;

use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\ImageProvider;

class PhotoProvider extends ImageProvider
{
    /**
     * {@inheritdoc}
     */
    protected function doTransform(MediaInterface $media)
    {
        parent::doTransform($media);

        $exifData = exif_read_data($media->getBinaryContent()->getPathname());

        if(isset($exifData['GPSLatitudeRef'])){
            $media->setGPSLatitudeRef($exifData['GPSLatitudeRef']);
        }
        if(isset($exifData['GPSLatitude'])){
            $media->setGPSLatitude(serialize($exifData['GPSLatitude']));
        }
        if(isset($exifData['GPSLongitudeRef'])){
            $media->setGPSLongitudeRef($exifData['GPSLongitudeRef']);
        }
        if(isset($exifData['GPSLongitude'])){
            $media->setGPSLongitude(serialize($exifData['GPSLongitude']));
        }
        if(isset($exifData['GPSAltitudeRef'])){
            $media->setGPSAltitudeRef($exifData['GPSAltitudeRef']);
        }
        if(isset($exifData['GPSAltitude'])){
            $media->setGPSAltitude($exifData['GPSAltitude']);
        }
        if(isset($exifData['GPSTimeStamp'])){
            $media->setGPSTimeStamp(serialize($exifData['GPSTimeStamp']));
        }
        if(isset($exifData['GPSImgDirectionRef'])){
            $media->setGPSImgDirectionRef($exifData['GPSImgDirectionRef']);
        }
        if(isset($exifData['GPSImgDirection'])){
            $media->setGPSImgDirection($exifData['GPSImgDirection']);
        }
        if(isset($exifData['GPSLatitudeRef']) && isset($exifData['GPSLatitude']) && isset($exifData['GPSLongitudeRef']) && isset($exifData['GPSLongitude'])){
            $media->setLatitude($this->getGps($exifData["GPSLatitude"], $exifData['GPSLatitudeRef']));
            $media->setLongitude($this->getGps($exifData["GPSLongitude"], $exifData['GPSLongitudeRef']));
        }
        var_dump($media);exit;
    }
    private function getGps($exifCoord, $hemi) {

        $degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;

        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);

    }

    private function gps2Num($coordPart) {

        $parts = explode('/', $coordPart);

        if (count($parts) <= 0)
            return 0;

        if (count($parts) == 1)
            return $parts[0];

        return floatval($parts[0]) / floatval($parts[1]);
    }
}