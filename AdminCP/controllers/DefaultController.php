<?php

namespace app\AdminCP\controllers;

use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['logout'],
        'rules' => [
          [
            'actions' => ['logout'],
            'allow' => true,
            'roles' => ['@'],
          ],
          [
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'logout' => ['post','get'],
        ],
      ],
    ];
  }
  public function beforeAction($action){
    if (parent::beforeAction($action)){
      if (Yii::$app->user->isGuest && $action->id != 'login'){
        Yii::$app->user->loginUrl = ['default/login', 'return' => \Yii::$app->request->url];
        return $this->redirect(Yii::$app->user->loginUrl)->send();
      }else{
        return true;
      }
    }
  }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin($return = ""){
      if (!Yii::$app->user->isGuest) {
        if($return != ""){
          return $this->redirect($return);
        }
        return $this->goHome();
      }

      $model = new LoginForm();
      if ($model->load(Yii::$app->request->post()) && $model->login()) {
        if($return != ""){
          return $this->redirect($return);
        }
        return $this->goHome();
      }

      $model->password = '';
      return $this->render('login', [
        'model' => $model,
      ]);
    }

  /**
   * Logout action.
   *
   * @return Response
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->goHome();
  }

}
