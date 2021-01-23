<?php

  use app\helpers\AdminHelpers;
  use yii\helpers\Html;
  use yii\helpers\Url;

  $Menus = AdminHelpers::GetMenuFlat([0, -1], []);
?>
<div class="row">
  <div class="col-12">
    <?= Html::a('Thêm Menu', Url::toRoute(['menus/create']), ['class' => 'btn btn-info mb-2']); ?>
  </div>
  <div class="col-12">
    <?php
      echo $this->render('/layouts/_table', [
        'table' => [
          'id' => 'tbl_route',
          'title' => 'Routes Manager',
          'column' => [
            'id',
            'menu_name',
            'route_url',
            [
              'label' => 'parent_name',
              'display' => function ($model) {
                return Html::a($model['parent_name'], Url::toRoute(['menus/view', 'id' => $model['parent_id']]), ['class' => '' . ($model['parent_id'] == -1 ? 'badge-pill bg-dark' : ($model['parent_id'] == 0 ? 'badge-pill bg-primary' : 'btn-link'))]);
              }
            ],
            'sort',
          ],
          'data' => $Menus,
          'page' => false,
          'button' => [
            function ($item) {
              return Html::a('Chỉnh sửa', Url::toRoute(['menus/edit', 'id' => $item['id']]), ['class' => 'btn btn-info btn-sm']);
            },
            function ($item) {
              return Html::a('Xoá', Url::toRoute(['menus/remove', 'id' => $item['id']]), [
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
