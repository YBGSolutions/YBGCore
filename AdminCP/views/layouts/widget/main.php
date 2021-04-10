<?php
  use app\assets\AdminLTEAsset;
  use yii\helpers\Html;
  $this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');
  AdminLTEAsset::register($this);
  \app\assets\FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
  <!DOCTYPE html>
  <html lang="<?= Yii::$app->language ?>">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

  </head>
  <body class="hold-transition sidebar-mini layout-fixed text-sm accent-lightblue">
  <?php $this->beginBody() ?>
  <div class="wrapper">
    <div class="content" style="padding: 20px;">
      <!-- Content Wrapper. Contains page content -->
      <?= $content;?>
    </div>
    <!-- /.control-sidebar -->
  </div>
  <?php $this->endBody() ?>
  </body>
  </html>
<?php $this->endPage() ?>