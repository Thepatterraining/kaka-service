<?php
namespace App\Http\Validation;

use Illuminate\Support\Facades\DB;

/**
 * 验证支付密码是否包含
 *
 * @author  zhoutao(zhoutao@kakamf.com)
 * @version 0.1
 */
class PayPwd
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
            } elseif (preg_match('/^[0-9A-Z]+$/', $value)) {
                return false;
            } elseif (preg_match('/^[0-9a-z]+$/', $value)) {
                return false;
            } elseif (preg_match('/^[a-zA-Z]+$/', $value)) {
                return false;
            } elseif (preg_match('/^[\sA-Z]+$/', $value)) {
                return false;
            } elseif (preg_match('/^[\sa-z]+$/', $value)) {
                return false;
            } elseif (preg_match('/^[\s0-9]+$/', $value)) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function replace($message, $attribute, $rule, $parameters)
    {
        return "支付密码需要至少包含大小写字母、数字、符号中任意三种";
    }
}
