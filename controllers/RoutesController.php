<?php

  namespace app\controllers;

  class RoutesController extends CMSController {

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
      return $this->render('index');
    }
  }
