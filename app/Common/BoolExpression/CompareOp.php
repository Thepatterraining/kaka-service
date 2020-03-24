<?php
namespace App\Common\BoolExpression;

use Illuminate\Support\Facades\DB;

class CompareOp
{
    
    /**
     * 表达式比较符转换
     *
     * @param   value 一次拆分字符串或bool值
     * @author  liu
     * @version 0.1
     */
    public function AtomCompression($value, $leftExpFactory, $rightExpFactory)
    {
        //  $leftExpFactory=$this->leftFactory;
        //  $rightExpFactory=$this->rightFactory;
        $tmp=array();
         
        if ($value===true || $value===false) {
            return $value;
        } else if (strstr($value, ">>")==true) { //大于符号转换
            $tmp=explode(">>", $value);
            $leftExp=$leftExpFactory->getExp($tmp[0]);
            $rightExp=$rightExpFactory->getExp($tmp[1]);
            return $this->handle($leftExp, $rightExp, ">");
        } else if (strstr($value, "<<")==true) {    //小于符号转换{
            $tmp=explode("<<", $value);
            $leftExp=$leftExpFactory->getExp($tmp[0]);
            $rightExp=$rightExpFactory->getExp($tmp[1]);
            return $this->handle($leftExp, $rightExp, "<");
        } else if (strstr($value, "<>")==true) { //不等于符号转换
            $tmp=explode("<>", $value);
            $leftExp=$leftExpFactory->getExp($tmp[0]);
            $rightExp=$rightExpFactory->getExp($tmp[1]);
            return $this->handle($leftExp, $rightExp, "!=");
        } else if (strstr($value, ">=")==true) {   //大于等于符号转换
            $tmp=explode(">=", $value);
            $leftExp=$leftExpFactory->getExp($tmp[0]);
            $rightExp=$rightExpFactory->getExp($tmp[1]);
            return $this->handle($leftExp, $rightExp, ">=");
        } else if (strstr($value, "<=")==true) {  //小于等于符号转换
            $tmp=explode("<=", $value);
            //  dump($tmp);
            $leftExp=$leftExpFactory->getExp($tmp[0]);
            $rightExp=$rightExpFactory->getExp($tmp[1]);
            return $this->handle($leftExp, $rightExp, "<=");
        } else if (strstr($value, "==")==true) {
            $tmp=explode("==", $value);
            $leftExp=$leftExpFactory->getExp($tmp[0]);
            $rightExp=$rightExpFactory->getExp($tmp[1]);
            return $this->handle($leftExp, $rightExp, "=");
        } else {//其余符号暂时不做变动
            $leftExp=null;
            $rightExp=$rightExpFactory->getExp($tmp[1]);
            return $this->handle($leftExp, $rightExp);
        }
    }

    /**
     * 表达式比较
     *
     * @param   leftExp 转换后左值
     * @param   rightExp 转换后右值
     * @param   compare 比较字符串
     * @author  liu
     * @version 0.1
     */
    private function handle($leftExp, $rightExp, $compare=null)
    {
        //当三者均不为空时进行比较
        if ($compare!=null && $leftExp!=null && $rightExp!=null) {
            switch ($compare) {
            case ">":
                if ($this->checkDateIsValid($leftExp)) {
                    if (strtotime($leftExp) > strtotime($rightExp)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($leftExp > $rightExp) {
                        return true;
                    } else {
                        return false;
                    }
                }
                    
                break;
            case "<":
                if ($this->checkDateIsValid($leftExp)) {
                    if (strtotime($leftExp) < strtotime($rightExp)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($leftExp < $rightExp) {
                        return true;
                    } else {
                        return false;
                    }
                }
            case ">=":
                if ($this->checkDateIsValid($leftExp)) {
                    if (strtotime($leftExp) >= strtotime($rightExp)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($leftExp >= $rightExp) {
                        return true;
                    } else {
                        return false;
                    }
                }
            case "<=":
                if ($this->checkDateIsValid($leftExp)) {
                    if (strtotime($leftExp) <= strtotime($rightExp)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($leftExp <= $rightExp) {
                        return true;
                    } else {
                        return false;
                    }
                }
            case "<>":
                if ($this->checkDateIsValid($leftExp)) {
                    if (strtotime($leftExp) != strtotime($rightExp)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($leftExp != $rightExp) {
                        return true;
                    } else {
                        return false;
                    }
                }
            case "=":
                if ($this->checkDateIsValid($leftExp)) {
                    if (strtotime($leftExp) == strtotime($rightExp)) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if ($leftExp == $rightExp) {
                        return true;
                    } else {
                        return false;
                    }
                }
            default:
                return null;
                    break;
            }
        }
    }

    private function checkDateIsValid($date)
    {
        $unixTime = strtotime($date);
        if (!$unixTime) { //strtotime转换不对，日期格式显然不对
            return false;
        } else {
            return true;
        }
    }
}
