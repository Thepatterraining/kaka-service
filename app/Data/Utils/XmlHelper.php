<?php
namespace App\Data\Utils;

class XmlHelper
{
    public static function decode($xmlStr)
    {
        // $obj = simplexml_load_string($str);
        $xmlObj = simplexml_load_string($xmlStr);

        $obj = array();
        foreach ($xmlObj->children() as $child) {
                  $obj[$child->getname()]=$child->__toString();
        }
        return $obj;
    }

}
