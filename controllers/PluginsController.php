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
      $ListRouteEvent = EventHelpers::GetEvents(ActionEvent::OnPublicRouteLoader);
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
              if($key->isOptional()){
                $params[] = $key->getDefaultValue();
              }else{
                die("parameter ".$key->name." is missing");
              }
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
        $content = "Route URL is not define: ".$r." or content is empty";
      }
      return $this->render('view', ['content'=>$content]);
    }
  }