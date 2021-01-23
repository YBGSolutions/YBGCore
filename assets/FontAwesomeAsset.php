<?php
namespace app\assets;
use yii\web\AssetBundle;

/**
 * FontAwesome AssetBundle
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@webroot/plugins/fontawesome-pro';

    public $css = [
        'css/all.min.css',
    ];
}