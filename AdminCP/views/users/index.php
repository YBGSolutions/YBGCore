<?php

  use app\helpers\AdminHelpers;
  use yii\helpers\Html;
  use yii\helpers\Url;

//  $Menus = AdminHelpers::GetMenuFlat([0, -1], []);
?>
<div class="row">
  <div class="col-12">
    <?= Html::a('Thêm người dùng', Url::toRoute(['users/create']), ['class' => 'btn btn-info mb-2']); ?>
  </div>
  <div class="col-12">
    <?php
      echo $this->render('/layouts/_table', [
        'table' => [
          'id' => 'tbl_route',
          'title' => 'Users Manager',
          'column' => [
            'id',
            'username',
            'email',
            [
              'label'=>'status',
              'display'=> function($model){
                $isDisabled = $model['status'] == 0;
                return "<span class='btn btn-sm ".($isDisabled?'btn-danger':'btn-success')."'>".($isDisabled?'Disabled':'Enabled')."</span>";
              }
            ],
            'group_id'
          ],
          'data' => $Users,
          'page' => false,
          'button' => [
            function ($item) {
              return Html::a('Chỉnh sửa', Url::toRoute(['users/edit', 'id' => $item['id']]), ['class' => 'btn btn-info btn-sm']);
            },
            function ($item) {
              return Html::a('Xoá', Url::toRoute(['users/remove', 'id' => $item['id']]), [
                'class' => 'btn btn-danger btn-sm',
                'data' => [
                  'confirm' => 'Are you sure you want to delete this item?'
                ]
              ]);
            }
          ]
        ]
      ]);
    ?>
  </div>
</div>
