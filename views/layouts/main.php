<?php
  $module = Yii::$app->controller->module;
  $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
  switch ($module->id){
    case "admin":
      echo $this->render('admin/main',['content' => $content, 'directoryAsset' => $directoryAsset]);
      break;
    default:
      echo $this->render('site/main',['content' => $content, 'directoryAsset' => $directoryAsset]);
      break;
  }
