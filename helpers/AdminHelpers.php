<?php
namespace app\helpers;

use app\models\Menus;

class AdminHelpers{
  public static function GetMenu($pid, $CurrentMenu = []){
    $Menus = Menus::find()->where(['parent_id'=>$pid,'is_active'=>1])->orderBy('sort ASC')->asArray()->all();
    if(count($Menus) <=0)
      return [];
    if(is_array($pid)){
      foreach($Menus as $menu){
        $CurrentMenu[$menu['id']] = $menu;
        $children = self::GetMenu($menu['id'], $CurrentMenu);
        if(count($children) > 0)
          $CurrentMenu[$menu['id']]['child'] = $children;
      }
    }else{
      $NewMenu = [];
      foreach($Menus as $menu){
        $NewMenu[$menu['id']] = $menu;
        $children = self::GetMenu($menu['id'], $NewMenu);
        if(count($children) > 0)
          $NewMenu[$menu['id']]['child'] = $children;
      }
      return $NewMenu;
    }
    return $CurrentMenu;
  }

  public static function GetMenuFlat($pid, $CurrentMenu = [], $parentName = ""){
    $Menus = Menus::find()->where(['parent_id'=>$pid,'is_active'=>1])->orderBy('sort ASC')->asArray()->all();
    if(count($Menus) <=0)
      return [];
    if(is_array($pid)){
      foreach($Menus as $menu){
        if($menu['parent_id'] == -1){
          $menu['parent_name'] = 'Header';
        }else if($menu['parent_id'] == 0){
          $menu['parent_name'] = 'Root';
        }else{
          $menu['parent_name'] = $parentName;
        }
        $CurrentMenu[] = $menu;
        $children = self::GetMenuFlat($menu['id'], $CurrentMenu, $menu['menu_name']);
        if(count($children) > 0)
          $CurrentMenu = array_merge($CurrentMenu, $children);
      }
    }else{
      $NewMenu = [];
      foreach($Menus as $menu){
        if($menu['parent_id'] == -1){
          $menu['parent_name'] = 'Header';
        }else if($menu['parent_id'] == 0){
          $menu['parent_name'] = 'Root';
        }else{
          $menu['parent_name'] = $parentName;
        }
        $NewMenu[] = $menu;
        $children = self::GetMenuFlat($menu['id'], $NewMenu, $menu['menu_name']);
        if(count($children) > 0)
          $NewMenu = array_merge($NewMenu, $children);
      }
      return $NewMenu;
    }
    return $CurrentMenu;
  }

  public static function BuildMenuWidget($CurrentMenus){
    $MenuData = [];
    foreach($CurrentMenus as $menu){
      $eachData = [
        'label' => $menu['menu_name'],
        'icon' => $menu['icon'],
        'url' => [$menu['route_url']]
      ];
      if($menu['parent_id'] == -1){
        $eachData['header'] = true;
      }
      if(isset($menu['child'])){
        $eachData['items'] = self::BuildMenuWidget($menu['child']);
      }
      $MenuData[] = $eachData;
    }
    return $MenuData;
  }

  public static function StartsWith($haystack, $needle) {
    return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
  }

  public static function EndsWith($haystack, $needle) {
    return substr_compare($haystack, $needle, -strlen($needle)) === 0;
  }
}