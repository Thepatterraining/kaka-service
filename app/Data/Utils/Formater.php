<?php
namespace App\Data\Utils;

class Formater
{

    public static function ceil($value, $places = 2)
    {
        if ($places < 0) {
            $places = 0;
        }
        $mult = pow(10, $places);
        $tmpValue = floor($value*$mult);
        $x = floor($value*$mult*10)-$tmpValue*10;
        if ($x > 0) {
            $value = $tmpValue + 1;
        } else {
            $value = $tmpValue;
        }
        //$value = $x > 0 ? $tmpValue:$tmpValue +1;
        return $value/  $mult;
    }


    public static function floor($value, $places = 2)
    {
        if ($places < 0) {
            $places = 0;
        }
        $mult = pow(10, $places);
        $tmpValue = floor($value*$mult);
        $x = floor($value*$mult*10)-$tmpValue*10;
         
          $value = $tmpValue;
      
        //$value = $x > 0 ? $tmpValue:$tmpValue +1;
        return $value/   $mult;
    }
}
