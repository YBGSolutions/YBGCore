<?php

  use yii\widgets\ActiveForm;

  if (!isset($form) || !isset($form['model'])):
    echo "DATA NOT FOUND!";
  else:
    /**
     * @var \yii\db\ActiveRecord
     */
    $model = $form['model'];
    $fields = $form['fields'];
?>
<?php
    $form = ActiveForm::begin([
      'id' => $form['id'],
      'options' => ['class' => 'form-verticle'],
    ]);
?>

    <div class="card card-cyan">
  <div class="card-header">
    <h3 class="card-title"><?=$title;?></h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
    <div class="card-body">
      <?php
        foreach ($model->attributes as $attribute => $value){
          if(isset($fields[$attribute])){
            if(is_callable($fields[$attribute])){
              echo $fields[$attribute]($form);
            }else if(is_array($fields[$attribute]))
              echo $fields[$attribute]['display']($form);
          }else{
            echo $form->field($model, $attribute);
          }
        }
      ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <input type="submit" class="btn btn-info" value="<?=$model->isNewRecord?'Thêm mới':'Chỉnh sửa';?>"></input>
      <span class="btn btn-warning">Quay lại</span>
    </div>
</div>
<?php
    ActiveForm::end();
  endif;
?>

