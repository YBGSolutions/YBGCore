<?php
  use yii\widgets\ActiveForm;

?>
<div class="row">
    <div class="col-12">
      <?php
        $Groups = \app\models\UserGroups::find()->select(['id', 'name'])->asArray()->all();
        $GroupsArray = array_column($Groups, 'name', 'id');
        $Users = \app\models\User::find()->select(['id', 'username'])->asArray()->all();
        $UsersArray = array_column($Users, 'username', 'id');
        echo $this->render('/layouts/_form', ['title' => 'Thêm User', 'form' => [
          'id' => 'create_users',
          'model' => $model,
          'fields' => [
            'id' => [
              'display' => function (ActiveForm $form) use ($model) {
                return $form->field($model, 'id')->hiddenInput()->label(false);
              }
            ],
            'password_hash' => function (ActiveForm $form) use ($model) {
              return $form->field($model, 'password_hash')->label("Mật Khẩu");
            },
            'username',
            'phone',
            'auth_key' => function (ActiveForm $form) use ($model) {
              return $form->field($model, 'auth_key')->hiddenInput(['value'=>'auth_key'])->label(false);
            },
            'status',
            'group_id' =>[
              'display' => function(ActiveForm $form) use($model, $GroupsArray){
                return $form->field($model, 'group_id')
                  ->dropDownList($GroupsArray)->label("Nhóm người dùng");
              }
            ],
            'status' => [
              'display' => function (ActiveForm $form) use ($model) {
                return $form->field($model, 'status')->checkBox(['label' => 'Is Active']);
              }
            ],
            'created_at' => false,
            'updated_at' => false,
            'password_reset_token' => false,
          ]
        ]
        ]);
      ?>
    </div>
</div>