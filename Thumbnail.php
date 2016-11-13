<?php

namespace ipoz\yii2\thumbnail;

use yii\base\Component;

/**
 * Class Thumbnail
 * @package ipoz\yii2\fthumbnail
 */
class Thumbnail extends Component
{
    /**
     * @var string
     */
    public $repositoryDir;

    private $subDir;
    private $originalImageName;
    private $separator;

    public function init()
    {
        parent::init();
        if (empty($this->repositoryDir)) {
            throw new \InvalidArgumentException('repositoryDir is empty');
        }

        if (!file_exists($this->repositoryDir)) {
            throw new \Exception($this->repositoryDir . ' do not exists');
        }
        $this->separator = DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $imageName
     * @param int $width
     * @param int $height
     * @param string $subDir
     * @return string
     */
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
        $separator = substr($dirName, 0, 1) !== $this->separator ? $this->separator : '';
        $this->subDir = !empty($dirName) ? $separator . $dirName : '';
    }

    private function getThumbnailPath($width, $height)
    {
        $fileName = $width . 'x' . $height . '_' . $this->originalImageName;
        return $this->repositoryDir . $this->subDir . $this->separator . $fileName;
    }

}