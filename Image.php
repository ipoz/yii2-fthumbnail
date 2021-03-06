<?php

namespace ipoz\yii2\thumbnail;


class Image extends \yii\imagine\Image
{

    /**
     * @param string $image
     * @return mixed
     */
    public static function getSize($image)
    {
        $img = static::ensureImageInterfaceInstance($image);
        return $img->getSize();
    }

    /**
     * @param string $image
     * @param int $width
     * @param int $height
     * @return array
     */
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

    /**
     * @param string $image
     * @return string
     */
    public static function getMimeType($image)
    {
        $fi = new \finfo(FILEINFO_MIME_TYPE);
        return $fi->file($image);
    }
}