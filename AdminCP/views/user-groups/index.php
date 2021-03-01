<?php

  use app\helpers\AdminHelpers;
  use yii\helpers\Html;
  use yii\helpers\Url;

  //  $Menus = AdminHelpers::GetMenuFlat([0, -1], []);
?>
<div class="row">
  <div class="col-12">
    <?= Html::a('Thêm nhóm người dùng', Url::toRoute(['user-groups/create']), ['class' => 'btn btn-info mb-2']); ?>
  </div>
  <div class="col-12">
    <?php
      echo $this->render('/layouts/_table', [
        'table' => [
          'id' => 'tbl_user_groups',
          'title' => 'Quản lý nhóm thành viên',
          'column' => [
            'id',
            'name',
            'desc'
          ],
          'data' => $UserGroups,
          'page' => false,
          'button' => [
            function ($item) {
              return Html::a('Chỉnh sửa', Url::toRoute(['user-groups/edit', 'id' => $item['id']]), ['class' => 'btn btn-info btn-sm']);
            },
            function ($item) {
              return Html::a('Xoá', Url::toRoute(['user-groups/remove', 'id' => $item['id']]), [
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
