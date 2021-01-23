<?php
namespace app\assets;
use yii\web\AssetBundle;

class PluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';

    public static $pluginMap = [
        'fontawesome' => [
            'css' => 'fontawesome-free/css/all.min.css'
        ],
        'icheck-bootstrap' => [
            'css' => ['icheck-bootstrap/icheck-bootstrap.css']
        ],
        'datatables'=>[
            'css'=>[
                'datatables-bs4/css/dataTables.bootstrap4.min.css',
                'datatables-responsive/css/responsive.bootstrap4.min.css'
                ],
            'js'=>[
                'datatables/jquery.dataTables.min.js',
                'datatables-bs4/js/dataTables.bootstrap4.min.js',
                'datatables-responsive/js/dataTables.responsive.min.js',
                'datatables-responsive/js/responsive.bootstrap4.min.js'
            ]
        ]
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
    /**
     * add a plugin dynamically
     * @param $pluginName
     * @return $this
     */
    public function add($pluginName)
    {
        $pluginName = (array)$pluginName;

        foreach ($pluginName as $name) {
            $plugin = $this->getPluginConfig($name);
            if (isset($plugin['css'])) {
                foreach ((array)$plugin['css'] as $v) {
                    $this->css[] = $v;
                }
            }
            if (isset($plugin['js'])) {
                foreach ((array)$plugin['js'] as $v) {
                    $this->js[] = $v;
                }
            }
        }

        return $this;
    }
    /**
     * @param $name plugin name
     * @return array|null
     */
    private function getPluginConfig($name)
    {
        return self::$pluginMap[$name] ?? null;
    }
}