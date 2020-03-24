<?php
namespace Cybereits\Common\Utils;

class RandomMaker
{
    public static function getRandomString($len)
    {
        $chars = array_merge(range(1, 9), range('a', 'z'), range('A', 'Z'));
        $str = '';
        $len = 6;
        $arr_len = count($chars)-1;
        if ($arr_len > 0 && $len > 0) {
            for ($i = 0; $i < $len; $i++) {
                $str .= $chars[mt_rand(0, $arr_len)];
            }
        }
        return $str;
    }
}
