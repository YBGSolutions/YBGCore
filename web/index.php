<?php

  use app\plugins\ActionEvent;
  use app\plugins\EventHelpers;
  use app\plugins\PluginAutoLoader;

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  // comment out the following two lines when deployed to production
  defined('YII_DEBUG') or define('YII_DEBUG', true);
  defined('YII_ENV') or define('YII_ENV', 'dev');
  require __DIR__ . '/../vendor/autoload.php';
  require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
  $config = require __DIR__ . '/../config/web.php';
  require_once __DIR__ . '/../plugins/PluginAutoLoader.php';
  (new yii\web\Application($config))->run();
  $yiiLoadedEvents = EventHelpers::GetEvents(ActionEvent::OnYiiLoaded);
  foreach ($yiiLoadedEvents as $event){
    if(is_callable($event)){
      $event();
    }
  }
