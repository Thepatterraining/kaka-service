<?php
$value = $argv[1];
$places = $argv[2];
echo round_out($value, $places)."\n";
echo round_out_1($value, $places)."\n";
function round_out($value, $places = 0)
{
    if ($places < 0) {
        $places = 0;
    }
    $mult = pow(10, $places);
    return ($value >= 0 ? ceil($value * $mult):floor($value * $mult)) / $mult;
}
function round_out_1($value, $places)
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
    return $value/100;
}
