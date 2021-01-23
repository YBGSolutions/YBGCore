<?php
if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
  echo $this->render(
        'main-login',
        ['content' => $content]
    );
    die;
}
use app\assets\AdminLTEAsset;
use app\assets\PluginAsset;
use yii\helpers\Html;
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
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
            <!-- Navbar -->
            <?= $this->render(
                'navbar',
                ['directoryAsset' => $directoryAsset]
            ) ?>
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            <?= $this->render(
                'sidebar',
                ['directoryAsset' => $directoryAsset]
            ) ?>
            <!-- Content Wrapper. Contains page content -->
            <?= $this->render(
                'content',
                ['content'=>$content, 'directoryAsset' => $directoryAsset]
            ) ?>
            <!-- /.content-wrapper -->
            <?= $this->render(
                'footer',
                ['directoryAsset' => $directoryAsset]
            ) ?>
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->
        </div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>