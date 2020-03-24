<?php
namespace App\Data\Common;
use App\Common\BoolExpression\IValExpression;

class RightExpFactory implements IValExpression
{
    /**
     * 右值转换
     *
     * @param   value 右值字符串
     * @author  liu
     * @version 0.1
     */
    public function GetExp($value)
    {
        return $value;
    }
}