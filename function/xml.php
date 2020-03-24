<?php


function decodeXML($xmlStr)
{
       // $obj = simplexml_load_string($str);
        $xmlObj = simplexml_load_string($xmlStr);

        $obj = array();
        foreach ($xmlObj->children() as $child){

            var_dump($child);
            $obj[$child->getname()]=$child->__toString();
        }
        return $obj;
}