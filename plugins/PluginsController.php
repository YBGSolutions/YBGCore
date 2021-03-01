<?php
  namespace app\plugins;
  use Yii;

  class PluginsController{

    public static $MenuHeader = -1;
    public static $MenuRoot = 0;
    protected $Menu = [];
    protected $Route = [];
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
      EventHelpers::RegisterEvent(ActionEvent::OnYiiLoaded,array( $this, 'OnYiiLoaded'));
      static::Routes($this);
    }
    public function __destruct() {
      EventHelpers::RemoveEvent(ActionEvent::OnMenuLoader,array( $this, 'OnMenu'));
      EventHelpers::RemoveEvent(ActionEvent::OnRouteLoader,array( $this, 'OnRoute'));
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

    public function AddRoute($routeName, callable $func){
      if(!array_key_exists($routeName, $this->Route)){
        $this->Route[$routeName] = $func;
      }
    }

    public final function render($file, $params = [], $context = null){
      $pluginName = substr(strrchr(get_class($this), '\\'), 1);
      return Yii::$app->view->renderFile(__DIR__.'/'.$pluginName.'/views/'.$file.'.php', $params, $context);
    }
    public final function RenderLayout($file, $params = [], $context = null){
      $layoutPath = Yii::getAlias('@webroot')."/../AdminCP/views/layouts/";
      return Yii::$app->view->renderFile($layoutPath.$file.'.php', $params, $context);
    }
    public final function redirect($url, $statusCode = 302){
      return Yii::$app->response->redirect($url, $statusCode);
    }

    public static function Routes(PluginsController $ctl) {
      $class_methods = get_class_methods($ctl);
      $className = substr(strrchr(get_class($ctl), '\\'), 1);
      foreach ($class_methods as $method_name) {
        if(str_starts_with($method_name,"action")){
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
    const OnYiiLoaded = "OnYiiLoaded";
  }