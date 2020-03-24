<?php
namespace App\Http\Validation;

class CheckCashMulti
{


    /*****
     * 校验现金 
     * 第一种情况是提现，直接比较即可
     * 第二种是在下单时，需要 * 另一个参数
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
            $session = resolve('App\Http\Utils\Session');
        
            $cash = $value ;
        if ($value===null) {
            return false;
        }
        switch (count($parameters)) {
        case 0:
            $session->error  = 804001;
            return false;
        case 1:
            $key = $parameters[0];
            $data = $validator->getData();
            if (array_key_exists($key, $data)===false) {
                $session->error = 804002;
                return false;
            }
                    
            $mul = $data[$parameters[0]];
            $total = $mul*$value;
            //dump($total);
            break;
        default:
            $session->error = 804005;
            break;
        }

            return true;
    }

    
    public function replace($message, $attribute, $rule, $parameters)
    {

        return "";
    }
}
