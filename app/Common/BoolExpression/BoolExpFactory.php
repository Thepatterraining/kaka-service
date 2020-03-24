<?php
/**
 * 表达式工厂类
 */
namespace App\Common\BoolExpression;

use App\Data\Sys\ErrorData;
use SplStack;

class BoolExpFactory
{

    public function __construct($leftFac,$rightFac,$exp)
    {   
        $this->exp=$exp;
        $this->leftFactory=$leftFac;
        $this->rightFactory=$rightFac;
        $this->stack=new SplStack();
        $this->atomStack=new SplStack();
        $this->handleStack=new SplStack();
    }

    /**表达式与或字符拆分
     * @param tmp 字符串栈对应数量
     * @author liu
     * @version 0.1 
     */

     private function stackHandle($tmp)
     {
         $compareOp=new CompareOp();
        //字符串栈中存在高于存储位的数据时判断为需要进行一级拆分操作
         if($this->atomStack->count()>$tmp+1)
         {
             //将字符串栈的相关数据弹出并压入处理栈中，还原顺序
            while($this->atomStack->count()!=$tmp)
            {
                $this->handleStack->push($this->atomStack->top());
                $this->atomStack->pop();
                // dump($stack_2);
            }
             do
             {
                 //由于已判断需要进行一级拆分操作，数据压入格式为1.a 2.操作符 3.b，因此进行相应处理
                 $top_first=$this->handleStack->top();
                 $top_first=$compareOp->AtomCompression($top_first,$this->leftFactory,$this->rightFactory);
                 $this->handleStack->pop();
                 // dump($this->atomStack);
                 $compare=$this->handleStack->top();
                 $this->handleStack->pop();
                 // dump($this->atomStack);
                 $top_second=$this->handleStack->top();
                 // dump($top_second);
                 $top_second=$compareOp->AtomCompression($top_second,$this->leftFactory,$this->rightFactory);
                 switch($compare)
                 {
                     case '&&':
                     {
                         $res=$top_first && $top_second;
                         $this->handleStack->pop();
                         $this->handleStack->push($res);
                         break;
                     }
                     case '||':
                     {
                         $res=$top_first || $top_second;
                         $this->handleStack->pop();
                         $this->handleStack->push($res);
                         break;
                     }
                     default:
                     {
                         return ErrorData::ERROR_EXPRESSION;
                     }
                 }
             }
             while($this->atomStack->count()>$tmp+1);
             $lastTop=$this->handleStack->top();
             $this->stack->pop();
             $this->handleStack->pop();
         }
         //字符串栈只有一个元素时判断为只需进行二次拆分
        else
        {
            $lastTop=$this->atomStack->top();
        } 
        $tmp=$compareOp->AtomCompression($lastTop,$this->leftFactory,$this->rightFactory);
        if($tmp===null)
        {
            return ErrorData::ERROR_EXPRESSION;
        }
        $this->atomStack->push($tmp);  
        if(!$this->handleStack->isEmpty())
        {
            $this->handleStack->pop();
        }
        return $tmp;
     }

    /**获取表达式转换结果
     * @author liu
     * @version 0.1
     */

     public function handle()
     {
         $string=$this->exp;
         $count=strlen($string);
         //遍历字符串
         for($i=0;$i<$count;$i++)
         {
             // dump($string[$i]);
             switch($string[$i])
             {
                 //括号开始时先将字符串栈的数量纪录并存入标记栈中，之后将开始标记位存入
                 case '(':
                 {
                     $this->stack->push($this->atomStack->count());
                     $this->stack->push($string[$i]);
                     break;
                 }
                 //括号结束后先将对应开始标记位弹出标记栈，随后获取入栈时的字符串栈情况
                 case ')':
                 {
                     if($this->stack->top!='(')
                     {
                        return ErrorData::ERROR_EXPRESSION;
                     }
                     $this->stack->pop();
                     $tmp=$this->stack->top();
                     $this->stackHandle($tmp);
                     break;
                 }
                 //若两个&符号相连则判断为与符号，否则按照正常字符处理
                 case '&':
                 {
                     if($string[++$i]=='&')
                     {
                         $this->atomStack->push('&&');
                     }
                     else
                     {
                         $tmp=$this->atomStack->top().'&';
                         $this->atomStack->pop();
                         $this->atomStack->push($tmp);
                         $i--;
                     }
                     break;
                 }
                 //若两个|符号相连则判断为并符号，否则按照正常字符处理
                 case '|':
                 {
                     if($string[++$i]=='|')
                     {
                         $this->atomStack->push('||');
                     }
                     else
                     {
                         $tmp=$this->atomStack->top().'|';
                         $this->atomStack->pop();
                         $this->atomStack->push($tmp);
                         $i--;
                     }
                     break;
                 }
                 //填充字符串
                 default:
                 {
                     if(!$this->atomStack->isEmpty() && $this->atomStack->top()!='&&' && $this->atomStack->top()!='||')
                     {
                         $tmp=$this->atomStack->top().$string[$i];
                         $this->atomStack->pop();
                         $this->atomStack->push($tmp);
                     }
                     else
                     {
                         $this->atomStack->push($string[$i]);
                     }
                     break;
                 }
             }
             // dump($this->stack);
         } 
         if(!$this->stack->isEmpty())
         {
            return ErrorData::ERROR_EXPRESSION;
         }
         //最终写入标记位0收尾，进行单个判断处理
         $this->stack->push(0);
         $this->stackHandle(0);
         $res=$this->atomStack->top();
         return $res;
     }
}
