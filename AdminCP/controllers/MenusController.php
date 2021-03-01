<?php
  namespace app\AdminCP\controllers;

  use app\models\Menus;
  use Yii;

  class MenusController extends CMSController {
    public function actionIndex(){
      return $this->render('index');
    }

    public function actionEdit($id){
      $model = Menus::findOne(['id'=>$id]);
      if($model){
        if(Yii::$app->request->isPost){
          if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->save()){
              return $this->redirect(['edit', 'id'=>$model->id]);
            }
          }
        }
        return $this->render('create', ['model'=>$model]);
      }
      return $this->redirect('index');
    }

    public function actionCreate(){
      $model = new Menus();
      if(Yii::$app->request->isPost){
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          if($model->save()){
            return $this->redirect(['edit', 'id'=>$model->id]);
          }
        }
      }
      return $this->render('create', ['model'=>$model]);
    }

    public function actionRemove($id){
      $model = Menus::findOne(['id'=>$id]);
      if($model){
        $model->delete();
      }
      return $this->redirect('index');
    }
  }