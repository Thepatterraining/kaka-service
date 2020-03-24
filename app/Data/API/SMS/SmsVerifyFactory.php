<?php

namespace App\Data\API\SMS;

class SmsVerifyFactory
{

    public function CreateSms()
    {

        $cfg_array = config('sms');

        $env = config("app.env");

        if(is_array($cfg_array) 
            && count($cfg_array)>0 
            && array_key_exists($env, $cfg_array)
        ) {
            $ins_class = $cfg_array[$env];

            if(class_exists($ins_class)) {
                return new $ins_class();
            }
        }
        return new TestVerify();
    }
}