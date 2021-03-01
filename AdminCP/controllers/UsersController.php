<?php
  namespace app\AdminCP\controllers;

  use app\models\Menus;
  use app\models\User;
  use Yii;

  class UsersController extends CMSController {
    public function actionIndex(){
      $Users = User::find()->asArray()->all();
      return $this->render('index',['Users'=>$Users]);
    }

    public function actionEdit($id){
      $model = User::findOne(['id'=>$id]);
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
      $model = new User();
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
      $model = User::findOne(['id'=>$id]);
      if($model){
        $model->delete();
      }
      return $this->redirect('index');
    }
  }