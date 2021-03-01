<?php
  namespace app\AdminCP\controllers;

  use app\models\Menus;
  use app\models\User;
  use app\models\UserGroups;
  use Yii;

  class UserGroupsController extends CMSController {
    public function actionIndex(){
      $UserGroups = UserGroups::find()->asArray()->all();
      return $this->render('index',['UserGroups'=>$UserGroups]);
    }

    public function actionEdit($id){
      $model = UserGroups::findOne(['id'=>$id]);
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
      $model = new UserGroups();
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
      $model = UserGroups::findOne(['id'=>$id]);
      if($model){
        $model->delete();
      }
      return $this->redirect('index');
    }
  }