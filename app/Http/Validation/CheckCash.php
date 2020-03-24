<?php
namespace App\Http\Validation;

/*****
 * 校验现金 
 * 第一种情况是提现，直接比较即可
 * 第二种是在下单时，需要 * 另一个参数
 */
class CheckCash
{

       
    public function validate($attribute, $value, $parameters, $validator)
    {
        $session = resolve('App\Http\Utils\Session');
        $cash = $value ;
    }

    
    public function replace($message, $attribute, $rule, $parameters)
    {

        return "";
    }
}
