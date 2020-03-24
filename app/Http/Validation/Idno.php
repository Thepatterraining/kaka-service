<?php
namespace App\Http\Validation;

use Illuminate\Support\Facades\DB;
use App\Utils\Error;

/**
 * 验证一个身份证号码是否合法
 *
 * @author  zhoutao(zhoutao@kakamf.com)
 * @version 0.1
 */
class Idno
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        // 只能是18位
        if (strlen($value)!=18) {
            return false;
        }

        // 取出本体码
        $idcard_base = substr($value, 0, 17);

        // 取出校验码
        $verify_code = substr($value, 17, 1);

        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

        // 校验码对应值
        $verify_code_list = array('1', '0', 'X' ,'9', '8', '7', '6', '5', '4', '3', '2');

        // 根据前17位计算校验码
        $total = 0;
        for ($i=0; $i<17; $i++) {
            $total += substr($value, $i, 1)*$factor[$i];
        }

        // 取模
        $mod = $total % 11;

        // 比较校验码
        if (strtoupper($verify_code) == strtoupper($verify_code_list[$mod])) {
            return true;
        } else {
            return false;
        }
    }

    public function replace($message, $attribute, $rule, $parameters)
    {
        return "该身份证号码不是合法的";
    }
}
