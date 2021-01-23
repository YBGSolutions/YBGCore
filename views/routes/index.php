<?php
  use app\models\Routes;
  $allData = Routes::find()->asArray()->all();
?>
<div class="row">
  <div class="col-12">
    <?=\yii\helpers\Html::a('Thêm Route', \yii\helpers\Url::toRoute(['route/create']), ['class'=>'btn btn-primary mb-2']);?>
  </div>
  <div class="col-12">
    <?php
      echo $this->render('/layouts/_table', [
        'table' => [
          'id'=>'tbl_route',
          'title' => 'Routes Manager',
          'column'=>[
            'id',
            'route_url'
          ],
          'data' => $allData,
          'page'=>[
            'total'=>10,
            'current'=>1
          ],
          'button'=>[
            function($item){
              return \yii\helpers\Html::a('View', \yii\helpers\Url::toRoute(['route/view', 'id'=>$item['id']]), ['class'=>'btn btn-info btn-sm']);
            },
            function($item){
              return \yii\helpers\Html::a('Remove', \yii\helpers\Url::toRoute(['route/remove', 'id'=>$item['id']]), ['class'=>'btn btn-danger btn-sm']);
            }
          ]
        ]
      ]);
    ?>
  </div>
</div>
