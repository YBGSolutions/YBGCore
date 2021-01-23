<?php
  use yii\widgets\ActiveForm;

?>
<div class="row">
  <div class="col-12">
    <?php
      echo $this->render('/layouts/_form', ['title' => 'Thêm nhóm người dùng', 'form' => [
        'id' => 'create_user_group',
        'model' => $model,
        'fields' => [
          'id' => function (ActiveForm $form) use ($model) {
            return $form->field($model, 'id')->hiddenInput()->label(false);
          },
          'name',
          'desc' => function(ActiveForm $form) use($model){
            return $form->field($model, 'desc')->textarea();
          },
          'created_at' => false,
          'updated_at' => false,
        ]
      ]
      ]);
    ?>
  </div>
</div>