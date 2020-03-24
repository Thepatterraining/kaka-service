<?php
namespace App\Data\Util;

Class CrontabDateHelper
{
    public function Handle($exp,$month,$week,$day,$hour,$minute)
    {
        $handleArray=explode('', $exp);
        $minuteBool=$this->minuteBool($handleArray[0], $minute);
        $hourBool=$this->minuteBool($handleArray[1], $hour);
        $dayBool=$this->minuteBool($handleArray[2], $day);
        $weekBool=$this->minuteBool($handleArray[3], $week);
        $monthBool=$this->minuteBool($handleArray[4], $month);
        $res=$minuteBool and $hourBool and $dayBool and $weekBool and $monthBool;
        return $res;
    }
    protected function minuteBool($minuteExp,$minute)
    {
        $res=true;
        $minuteArray=explode(',', $minuteExp);
        if(count($minuteArray)==1) {
            $res=$this->minuteHandle($minuteExp, $minute);
        }
        else
        {
            foreach($minuteArray as $settlement)
            {
                $tmp=$this->minuteHandle($settlement, $minute);
                $res=$res or $tmp;
            }
        }
        return $res;
    }
    protected function minuteHandle($minuteExp,$minute)
    {
        $minuteArray=$minuteArray=explode('/', $minuteExp);
        if(count($minuteArray)==1) {
            if($minuteExp=='*') {
                return true;
            }
            else
            {
                if($minute==$minuteExp) {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            if(($minute - 0) % $minuteArray[1]==0) {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}