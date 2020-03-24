<?php
namespace App\Http\Validation;

use App\Data\Sys\DictionaryData;

/**
 * 验证字典表值
 *
 * @author    geyunfei(geyunfei@kakamf.com)
 * @version   0.1
 * @copyright Mar 7th,2017
 * 注册的验证规则dic  输入的第一个参数为字典的 dictype
 * 如 dic:bank 为验证是否为有效的银行名称
 */
class Dictionary
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $session = resolve('App\Http\Utils\Session');
        if ($session ->error!= null) {
            return ;
        }
        $dicFac = new DictionaryData();
        switch (count($parameters)) {
        case 0:
            $session->error =802001;
            return false;
        case 1:
            $item = $dicFac->getDictionary($parameters[0], $value);
            if ($item ==null) {
                $session->error =802002;
                return false;
            }
            break;
        default:
            $session->error =803002;
            return false ;
        }

          return true ;
    }

    public function replace($message, $attribute, $rule, $parameters)
    {

        return "";
    }
}
