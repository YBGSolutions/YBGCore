<?php
  namespace app\plugins;
  class EventHelpers{
    public static $ListEvents;
    public function __construct() {
      self::$ListEvents = [];
    }
    public static function RegisterEvent($name, callable $function){
      if(!is_callable($function))
        return;
      self::$ListEvents[$name][] = $function;
    }
    public static function RemoveEvent($name, callable $function){
      if(!is_callable($function))
        return;
      if(!array_key_exists($name, self::$ListEvents))
        return;
      $key = array_search($function, self::$ListEvents[$name]);
      if ($key !== false) {
        unset(self::$ListEvents[$name][$key]);
      }
    }
    public static function GetEvents($name){
      if(!array_key_exists($name, self::$ListEvents))
        return [];
      return self::$ListEvents[$name];
    }
  }