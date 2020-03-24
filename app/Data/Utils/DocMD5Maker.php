<?php
namespace App\Data\Utils;

use Illuminate\Database\Eloquent\Model;

class DocMD5Maker
{
    
    public static function AddHash(Model $item)
    {
        $modelClass  = get_class($item);
        if ($item->id ==null) {
            $item->save();
        }

        //  echo $item->id;
        $itemarray = $item->toArray();
        sort($itemarray);
     
        $strToMD5 = implode('_', $itemarray);
        if ($item->id > 1) {
            $last = $modelClass::where('id', $item->id-1)->first();
            if ($last!=null) {
                $strToMD5 = $strToMD5 . '_' . $last->hash;
            }
        }
       
        $item->hash = md5($strToMD5);
        return $item->save();
    }
    
    public static function CheckHash(Model $item)
    {
        $modelClass = get_class($item);
        $itemarray = array_values($item->toArray());
        
        $md5 = $item->hash;
        
        $index = array_search($md5, $itemarray);
     
        if ($index != false) {
            array_splice(
                $itemarray, $index, 1
            );
        }
        sort($itemarray);
    
        $strToMD5 = implode('_', $itemarray);
        
        if ($item->id > 1) {
            $last = $modelClass::where('id', $item->id-1)->first();

            $strToMD5 = $strToMD5.'_'.$last->hash;
        }
 
        $md5_check = md5($strToMD5);
    
        return $md5 == $md5_check;
    }
}
