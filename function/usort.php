<?php
/**
 * Created by PhpStorm.
 * User: zhoutao
 * Date: 2017/3/23
 * Time: 下午9:05
 */

function my_sort($a,$b)
{
    if ($a==$b) return 0;
    return ($a<$b)?-1:1;
}


