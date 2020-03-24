<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use SplStack;
use App\Data\Common\LeftExpFactory;
use App\Data\Common\RightExpFactory;
use App\Common\BoolExpression\CompareOp;

class ExperimentTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $stack_1=new SplStack();
        $stack_2=new SplStack();
        $stack_3=new SplStack();
        // $string="cash_pending>=1&&((reg_time>='2017-4-6'&&cash_availble>=100)||cash_pending>=1000000)||(availble_KKC-BJ0001>=1&&(pending_KKC-BJ0001>=1||reg_time<='2017-4-5'))";
        $string="cash_pending>=1";
        $count=strlen($string);
        for($i=0;$i<$count;$i++)
        {
            // dump($string[$i]);
            switch($string[$i])
            {
            case '(':
            {
                $stack_1->push($stack_2->count());
                $stack_1->push($string[$i]);
                break;
}
            case ')':
            {
                $stack_1->pop();
                $tmp=$stack_1->top();
                $element=$this->handle($stack_1, $stack_2, $stack_3, $tmp);
                if($element!=null) {
                    $stack_2->push($element);
                }
                break;
}
            case '&':
            {
                if($string[++$i]=='&') {
                    $stack_2->push('&&');
                }
                else
                {
                    $tmp=$stack_2->top().'&';
                    $stack_2->pop();
                    $stack_2->push($tmp);
                    $i--;
                }
                break;
}
            case '|':
            {
                if($string[++$i]=='|') {
                    $stack_2->push('||');
                }
                else
                {
                    $tmp=$stack_2->top().'|';
                    $stack_2->pop();
                    $stack_2->push($tmp);
                    $i--;
                }
                break;
}
            default:
            {
                if(!$stack_2->isEmpty() && $stack_2->top()!='&&' && $stack_2->top()!='||') {
                    $tmp=$stack_2->top().$string[$i];
                    $stack_2->pop();
                    $stack_2->push($tmp);
                }
                else
                {
                    $stack_2->push($string[$i]);
                }
                break;
}
            }
            dump($stack_1);
            dump($stack_2);
            dump($stack_3);
        } 
        $stack_1->push(0);
        $res=$this->handle($stack_1, $stack_2, $stack_3, 0);
        dump($stack_2->top());
        $this->assertTrue(true);
    }

    public function handle($stack_1,$stack_2,$stack_3,$tmp)
    {
        $leftExpFactory=new LeftExpFactory(1);
        $rightExpFactory=new RightExpFactory();
        $compareOp=new CompareOp();

        if($stack_2->count()>$tmp+1) {
            while($stack_2->count()!=$tmp)
            {
                $stack_3->push($stack_2->top());
                $stack_2->pop();
                // dump($stack_2);
            }
            do
            {
                $top_first=$stack_3->top();
                // dump($top_first);
                $top_first=$compareOp->AtomCompression($top_first, $leftExpFactory, $rightExpFactory);
                $stack_3->pop();
                // dump($stack_2);
                $compare=$stack_3->top();
                $stack_3->pop();
                // dump($stack_2);
                $top_second=$stack_3->top();
                // dump($top_second);
                $top_second=$compareOp->AtomCompression($top_second, $leftExpFactory, $rightExpFactory);
                switch($compare)
                {
                case '&&':
                {
                    $res=$top_first && $top_second;
                    $stack_3->pop();
                    $stack_3->push($res);
                    // dump($stack_3);
                    break;
}
                case '||':
                {
                    $res=$top_first || $top_second;
                    $stack_3->pop();
                    $stack_3->push($res);
                    break;
}
                default:
                {
                    return false;
}
                }
            }
            while($stack_3->count()>$tmp+1);
            $lastTop=$stack_3->top();
            $stack_1->pop();
            $stack_3->pop();
        }
        else
        {
            $lastTop=$stack_2->top();
        }
        
        // if(($lastTop===true)||($lastTop===false))
        // {
        //     return ;
        // }
        // else
        // {
            $tmp=$compareOp->AtomCompression($lastTop, $leftExpFactory, $rightExpFactory);
            $stack_2->push($tmp);  
        // } 
    }
}
