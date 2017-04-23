Generate image thumbnail ad-hoc for Yii2 project
===================================

Installation
----------
To install, either run
```
composer require ipoz/yii2-thumbnail
```
or add to the `required` section of your `composer.json` file
```
"ipoz/yii2-thumbnail": "*" 
```

Configuration app
----------
```php
'components' =>
[
    'thumbnail' => [
        'class' => 'ipoz\yii2\thumbnail\Thumbnail',
        'repositoryDir' => PATH_TO_YOUR_REPOSITORY
    ]

]
```

Example usage
----------
```php
use ipoz\yii2\thumbnail\Image;

...

public function actionThumbnail($image, $width, $height = 0, $type = '')
    {
        $imagePath = \Yii::$app->thumbnail->generateThumbnail($image, $width, $height, $type);
        return \Yii::$app->response->sendFile($imagePath, $image, [
            'mimeType' => Image::getMimeType($imagePath),
            'inline' => true,
        ]);
    }
```
