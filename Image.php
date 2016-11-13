<?php

namespace ipoz\yii2\thumbnail;


class Image extends \yii\imagine\Image
{

    public static function getSize($image)
    {
        $img = static::ensureImageInterfaceInstance($image);
        return $img->getSize();
    }

    public static function getNewSize($image, $width, $height)
    {
        $geo = self::getSize($image);
        $geoWidth = $geo->getWidth();
        $geoHeight = $geo->getHeight();

        if ($width > 0) {
            $newWidth = $width;
        } else {
            $newWidth = floor(($height * $geoWidth) / $geoHeight);
        }

        if ($height > 0) {
            $newHeight = $height;
        } else {
            $newHeight = floor(($width * $geoHeight) / $geoWidth);
        }

        return [
            $newWidth,
            $newHeight
        ];
    }

    public static function getMimeType($image)
    {
        $fi = new \finfo(FILEINFO_MIME_TYPE);
        return $fi->file($image);
    }
}