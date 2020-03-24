<?php
namespace App\Http\Validation;

/*****
 * 校验代币 
 * 第一种情况是提现,此时第一个参数为代币类型的输入
 * 第二种是在下单时，需要 * 另一个参数
 */
class CheckCoin
{

       
    public function validate($attribute, $value, $parameters, $validator)
    {
        $session = resolve('App\Http\Utils\Session');

        $coin = $value;


        switch (count($parameters)) {
        case 0:
            $session->error  = 805001;
            return false;
        case 1:
            $key = $parameters[0];
            $data = $validator->getData();
            if (array_key_exists($key, $data)===false) {
                $session->error = 805002;
                return false;
            }
            //在这里得到持币数量
            $mul = $data[$parameters[0]];
            $total = $mul*$value;
            //dump($total);
            break;
        default:
            $session->error = 804005;
            break;
        }
    }

    
    public function replace($message, $attribute, $rule, $parameters)
    {

        return "";
    }
}
