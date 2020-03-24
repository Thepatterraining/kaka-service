<?php

namespace App\Data\API\Email;

class EmailVerifyFactory {

    public function CreateEmail(){

        $cfg_array = config('emailcheck');

        $env = config("app.env");

        if(
            is_array($cfg_array) 
            && count($cfg_array)>0 
            && array_key_exists($env,$cfg_array)){
            $ins_class = $cfg_array[$env];

            if(class_exists($ins_class))
                return new $ins_class();
        }
        return new TestVerify();
    }
}