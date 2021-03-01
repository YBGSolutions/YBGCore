<?php
  use yii\widgets\ActiveForm;

  ?>
<div class="row">
  <div class="col-12">
    <?php
      echo $this->render('/layouts/_form', ['title' => 'Thêm Menu', 'form' => [
        'id' => 'create_menu',
        'model' => $model,
        'fields' => [
          'id' => [
            'display' => function (ActiveForm $form) use ($model) {
              return $form->field($model, 'id')->hiddenInput()->label(false);
            }
          ],
          'menu_name',
          'icon',
          'parent_id' =>[
            'display' => function(ActiveForm $form) use($model){
              $menuFlat = \app\helpers\AdminHelpers::GetMenuFlat([0,-1], []);
              $items = ['-1' => 'Header', '0' => 'Root'];
              foreach ($menuFlat as $menu){
                $items[$menu['id']] = $menu['menu_name'];
              }
              return $form->field($model, 'parent_id')
                ->dropDownList($items)->label("Thư mục cha");
            }
          ],
          'route_url',
          'sort' => [
            'display' => function (ActiveForm $form) use ($model) {
              return $form->field($model, 'sort')->textInput(['type' => 'number']);
            }
          ],
          'is_active' => [
            'display' => function (ActiveForm $form) use ($model) {
              return $form->field($model, 'is_active')->checkBox(['label' => 'Is Active']);
            }
          ],
          'created_at' => false,
          'updated_at' => false,
        ]
      ]
      ]);
    ?>
  </div>
</div>