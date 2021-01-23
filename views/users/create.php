<?php
  use yii\widgets\ActiveForm;

?>
<div class="row">
  <div class="col-12">
    <?php
      echo $this->render('/layouts/_form', ['title' => 'Thêm User', 'form' => [
        'id' => 'create_users',
        'model' => $model,
        'fields' => [
          'id' => [
            'display' => function (ActiveForm $form) use ($model) {
              return $form->field($model, 'id')->hiddenInput()->label(false);
            }
          ],
          'username',
          'email',
          'status',
          'group_id' =>[
            'display' => function(ActiveForm $form) use($model){
              $menuFlat = \app\helpers\AdminHelpers::GetMenuFlat([0,-1], []);
              $items = ['-1' => 'Header', '0' => 'Root'];
              foreach ($menuFlat as $menu){
                $items[$menu['id']] = $menu['menu_name'];
              }
              return $form->field($model, 'group_id')
                ->dropDownList($items)->label("Nhóm người dùng");
            }
          ],
          'status' => [
            'display' => function (ActiveForm $form) use ($model) {
              return $form->field($model, 'status')->checkBox(['label' => 'Is Active']);
            }
          ],
          'created_at' => false,
          'updated_at' => false,
          'auth_key' => false,
          'password_hash' => false,
          'password_reset_token' => false,
        ]
      ]
      ]);
    ?>
  </div>
</div>