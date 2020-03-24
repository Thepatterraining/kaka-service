<?php
namespace App\Http\Validation;

use Illuminate\Support\Facades\DB;

/**
 * 验证登陆密码是否包含字母数字或者符号
 *
 * @author  zhoutao(zhoutao@kakamf.com)
 * @version 0.1
 */
class Pwd
{

    public function validate($attribute, $value, $parameters, $validator)
    {

        $value = preg_replace('/([\x80-\xff]*)/i', '', $value);
        if (preg_match('/[\w\s]+/', $value)) {
            if (preg_match('/^[0-9]+$/', $value)) {
                return false;
            } elseif (preg_match('/^[a-z]+$/', $value)) {
                return false;
            } elseif (preg_match('/^[A-Z]+$/', $value)) {
                return false;
            } elseif (preg_match('/^[\s]+$/', $value)) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function replace($message, $attribute, $rule, $parameters)
    {
        return "登陆密码需要至少包含大小写字母、数字、符号中任意两种";
    }
}
