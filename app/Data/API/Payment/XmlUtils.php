<?php 
namespace App\Data\API\Payment;

class XmlUtils
{
   
    /**
     *
     *
     */
    public  static function xml_to_array($xml)
    {
        $array = (array)(simplexml_load_string($xml));
        foreach ($array as $key=>$item){
            $array[$key]  =  XmlUtils::struct_to_array((array)$item);
        }
        return $array;
    }
    private static function struct_to_array($item) 
    {
        if(!is_string($item)) {
            $item = (array)$item;
            foreach ($item as $key=>$val){
                $item[$key]  =XmlUtils::struct_to_array($val);
            }
        }
        return $item;

    }

    public static function array_to_xml($arr,$code = 'UTF-8')
    {
        $xml = "<?xml version = \"1.0\" encoding=\"".$code."\"?>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml.="<".$key.">".XmlUtils::item_to_xml($val)."</".$key.">";
            } else {
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
     
        return $xml; 
    }

    private static function item_to_xml($arr)
    {

        $xml = "";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml.= "<".$key.">".XmlUtils::item_to_xml($val)."</".$key.">";
            } else {
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        return $xml;
    }
     

}