<?php
  namespace app\plugins;
  use app\helpers\AdminHelpers;
  use Yii;
  use yii\helpers\Url;

  class PluginsController{

    public static $MenuHeader = -1;
    public static $MenuRoot = 0;
    protected $Menu = [];
    protected $Route = [];
    protected $PublicRoute = [];
    protected $requirePlugins = [];
    public function __construct() {
      if(count($this->requirePlugins) > 0){
        foreach ($this->requirePlugins as $req){
          if(!class_exists("app\\plugins\\".$req)){
            die("Plugin ".get_class($this)." required: ".$req);
          }
        }
      }
      EventHelpers::RegisterEvent(ActionEvent::OnMenuLoader,array( $this, 'OnMenu'));
      EventHelpers::RegisterEvent(ActionEvent::OnRouteLoader,array( $this, 'OnRoute'));
      EventHelpers::RegisterEvent(ActionEvent::OnPublicRouteLoader, [$this, 'OnPublicRoute']);
      EventHelpers::RegisterEvent(ActionEvent::OnYiiLoaded,array( $this, 'OnYiiLoaded'));
      static::Routes($this);
    }
    public function __destruct() {
      EventHelpers::RemoveEvent(ActionEvent::OnMenuLoader,array( $this, 'OnMenu'));
      EventHelpers::RemoveEvent(ActionEvent::OnRouteLoader,array( $this, 'OnRoute'));
      EventHelpers::RemoveEvent(ActionEvent::OnPublicRouteLoader, [$this, 'OnPublicRoute']);
      EventHelpers::RemoveEvent(ActionEvent::OnYiiLoaded,array( $this, 'OnYiiLoaded'));
    }
    public function OnYiiLoaded(){

    }

    public final function OnMenu(){
      return $this->Menu;
    }

    public final function OnRoute(){
      return $this->Route;
    }

    public final function OnPublicRoute(){
      return $this->PublicRoute;
    }

    public final function toRoute($route){
      $className = substr(strrchr(get_class($this), '\\'), 1);
      if(is_array($route)){
        $route[0] = str_replace("{0}", "p/".$className, $route[0]);
      }else{
        $route = str_replace("{0}", "p/".$className, $route);
      }
      return Url::toRoute($route);
    }

    public function AddMenu($MenuName, $Icon, $Route, $Slug, $parent = 0, $ParentSlug = ""){
      $menu = [
        "id" => $Slug,
        "icon" => $Icon,
        "menu_name" => $MenuName,
        "route_url" => "/admin/p/".$Route,
        "parent_id" => $parent
      ];
      if($ParentSlug != "" && array_key_exists($ParentSlug, $this->Menu)){
        $this->Menu[$ParentSlug]["child"][$Slug] = $menu;
      }else if(!array_key_exists($Slug, $this->Menu)){
        $this->Menu[$Slug] = $menu;
      }
    }

    public function AddRoute($routeName, callable $func, $isPublic = false){
      if(!$isPublic){
        if(!array_key_exists($routeName, $this->Route)){
          $this->Route[$routeName] = $func;
        }
      }else{
        if(!array_key_exists($routeName, $this->PublicRoute)){
          $this->PublicRoute[$routeName] = $func;
        }
      }
    }

    public final function render($file, $params = [], $context = null){
      $pluginName = substr(strrchr(get_class($this), '\\'), 1);
      $params['ctrl']=$this;
      return Yii::$app->view->renderFile(__DIR__.'/'.$pluginName.'/views/'.$file.'.php', $params, $context);
    }
    public final function RenderLayout($file, $params = [], $context = null){
      $layoutPath = Yii::getAlias('@webroot')."/../AdminCP/views/layouts/";
      return Yii::$app->view->renderFile($layoutPath.$file.'.php', $params, $context);
    }
    public final function redirect($url, $statusCode = 302){
      $className = substr(strrchr(get_class($this), '\\'), 1);
      if(is_array($url)){
        $url = str_replace("{0}", "p/".$className, $url);
      }else{
        $url = str_replace("{0}", "p/".$className, $url);
      }
      return Yii::$app->response->redirect($url, $statusCode);
    }

    public static function Routes(PluginsController $ctl) {
      $class_methods = get_class_methods($ctl);
      $className = substr(strrchr(get_class($ctl), '\\'), 1);
      foreach ($class_methods as $method_name) {
        if(AdminHelpers::StartsWith($method_name, 'actionPublic')){
          $method = substr($method_name, 12);
          $ctl->AddRoute("{$className}/".static::uncamelCase($method), [$ctl, $method_name], true);
        }else if(AdminHelpers::StartsWith($method_name,"action")){
          $method = substr($method_name, 6);
          $ctl->AddRoute("{$className}/".static::uncamelCase($method), [$ctl, $method_name]);
        }

      }
    }
    static function uncamelCase($str) {
      $str = preg_replace('/([a-z])([A-Z])/', "\\1-\\2", $str);
      $str = strtolower($str);
      return $str;
    }

    public static function _require_all($path, $depth=0, $isOnce = true) {
      $dirhandle = @opendir($path);
      if ($dirhandle === false) return;
      while (($file = readdir($dirhandle)) !== false) {
        if ($file !== '.' && $file !== '..') {
          $fullfile = $path . '/' . $file;
          if (is_dir($fullfile)) {
            PluginsController::_require_all($fullfile, $depth+1);
          } else if (strlen($fullfile)>4 && substr($fullfile,-4) == '.php') {
            if($isOnce)
              require_once $fullfile;
            else
              require $fullfile;
          }
        }
      }

      closedir($dirhandle);
    }
  }
  abstract class ActionEvent
  {
    const OnMenuLoader = "OnMenu";
    const OnHookingLoader = "OnHooking";
    const OnRouteLoader = "OnRoute";
    const OnPublicRouteLoader = "OnPublicRoute";
    const OnYiiLoaded = "OnYiiLoaded";
  }