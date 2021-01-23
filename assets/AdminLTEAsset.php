<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminLTEAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte';
    public $css = [
        'dist/css/adminlte.min.css',
        'plugins/overlayScrollbars/css/OverlayScrollbars.min.css'
    ];
    public $js = [
        'dist/js/adminlte.js',
        'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
