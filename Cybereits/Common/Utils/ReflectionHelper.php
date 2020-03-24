<?php
namespace Cybereits\Common\Utils;

class ReflectionHelper{
  public static function CreateImplementsLogic($env_array,$interface=null){
    
    $env = config("app.env");
    if(array_key_exists($env,$env_array)){
      $class = $env_array[$env];
      return new $class;
    }
    return null;
  }
}