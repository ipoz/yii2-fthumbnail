<?php

namespace ipoz\yii2\fthumbnail;

use Yii;
use yii\base\Component;

class Thumbnail extends Component
{
    public $repositoryDir = null;
    private $subDir = '';
    private $originalImageName = null;
    private $separator;

    public function init()
    {
        if (empty($this->repositoryDir)) {
            throw new \InvalidArgumentException('repositoryDir is empty');
        }

        if (!file_exists($this->repositoryDir)) {
            mkdir($this->repositoryDir, 0766, true);
        }
        $this->separator = DIRECTORY_SEPARATOR;
    }

    public function generateThumbnail($imageName, $width, $height = 0, $subDir = '')
    {
        $this->setSubDir($subDir);
        $this->setOriginalImagePath($imageName);
        $originalImage = $this->getOriginalImagePath();
        if (!file_exists($originalImage)) {
            throw new NotFoundHttpException('File do not exists');
        }

        list($newWidth, $newHeight) = Image::getNewSize($originalImage, $width, $height);

        $imagePath = $this->getThumbnailPath($width, $height);
        if (!file_exists($imagePath)) {
            Image::thumbnail($originalImage, $newWidth, $newHeight)->save($imagePath);
        }
        return $imagePath;
    }

    private function getOriginalImagePath()
    {
        return $this->repositoryDir . $this->subDir . $this->separator . $this->originalImageName;
    }

    private function setOriginalImagePath($imageName)
    {
        $this->originalImageName = $imageName;
    }

    private function setSubDir($dirName)
    {
        //Sprawdzić czy zaczyna sie od /
        $this->subDir = !empty($dirName) ? $this->separator . $dirName : '';
        if (!empty($this->subDir) && !file_exists($this->repositoryDir)) {
            mkdir($this->repositoryDir . $this->subDir, 0766, true);
        }
    }

    private function getThumbnailPath($width, $height)
    {
        $fileName = $width . 'x' . $height . '_' . $this->originalImageName;
        return $this->repositoryDir . $this->subDir . $this->separator . $fileName;
    }

}