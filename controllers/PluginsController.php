<?php

  namespace app\controllers;

  use app\plugins\ActionEvent;
  use app\plugins\EventHelpers;
  use Closure;
  use ReflectionFunction;
  use yii\web\Response;

  class PluginsController extends CMSController {

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
      return $this->render('index');
    }

    public function actionView($r){
      $ListRouteEvent = EventHelpers::GetEvents(ActionEvent::OnRouteLoader);
      $content = "";
      foreach($ListRouteEvent as $event){
        $route = $event();
        if(array_key_exists($r, $route)){
          $closure = Closure::fromCallable($route[$r]);
          $ref = new ReflectionFunction($closure);
          $paramsKey = $ref->getParameters();
          $params = [];
          foreach ($paramsKey as $key){
            if(array_key_exists($key->name, $_GET)){
              $params[] = $_GET[$key->name];
            }else{
              $params[] = null;
            }
          }
          $content = call_user_func_array($route[$r], $params);
          if($content instanceof Response){
            $content->send();
            return true;
          }
          break;
        }
      }
      if($content == ""){
        $content = "Route URL is not define: ".$r;
      }
      return $this->render('view', ['content'=>$content]);
    }
  }
