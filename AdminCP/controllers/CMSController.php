<?php
  namespace app\AdminCP\controllers;
  use Yii;
  use yii\filters\AccessControl;
  use yii\filters\VerbFilter;
  use yii\web\Controller;

  class CMSController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
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
            'logout' => ['post'],
          ],
        ],
      ];
    }

    public function beforeAction($action) {
      if (parent::beforeAction($action)) {
        if (Yii::$app->user->isGuest && $action->id != 'login') {
          Yii::$app->user->loginUrl = ['site/login', 'return' => \Yii::$app->request->url];
          return $this->redirect(Yii::$app->user->loginUrl)->send();
        } else {
          return true;
        }
      }
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
      return [
        'error' => [
          'class' => 'yii\web\ErrorAction',
        ],
        'captcha' => [
          'class' => 'yii\captcha\CaptchaAction',
          'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
        ],
      ];
    }
  }