<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Cash\BankAccountData;
use App\Data\User\CashAccountData;
//use App\Data\User\UserData;
use App\Data\Trade\TranactionOrderData;

class RakebackTypeData extends IDatafactory
{
    protected $modelclass = 'App\Model\Sys\RakebackType';

    public function getUserRechargeRakeBack($tranactionCount)
    {
        $model=$this->newitem();
        $index=$model->where('user_rbtype_lrecharge', '<=', $tranactionCount);
        if(empty($indexInfo)) {
            return 0;
        }
        else
        {
            $index=$indexInfo->where('user_rbtype_tbuy', '>', $tranactionCount)->first();
        }
        $rakeBackInfo=$this->getRakeBackInfo($index);
        if(empty($rakeBackInfo)) {
            return null;
        }
        if($rakeBackInfo->user_rbtype_enable == false) {
            return 0;
        }
        else
        {
            $result=0;
            while($index>0){
                $val=$rakeBackInfo->user_rbtype_buyrate;
                $low=$rakeBackInfo->user_rbtype_lbuy;
                $result=$result + ($tranactionCount-$low) * $val;
                if($index>1) {
                    $index--;
                    $rakeBakeInfo=$this->getRakeBackInfo($index);
                    $tranactionCount=$rakeBakeInfo->user_rbtype_tbuy;
                }
            }

            return $result;
        }
    }

    public function getUserBuyRakeBack($tranactionCount)
    {
        $model=$this->newitem();
        $indexInfo=$model->orderBy('user_rbtype_lbuy', 'desc')->where('user_rbtype_lbuy', '<=', $tranactionCount)->first();
        //->where('user_rbtype_tbuy','<',$tranactionCount)->first();
        if(empty($indexInfo)) {
            return 0;
        }

        if($indexInfo->user_rbtype_enable == false) {
            return 0;
        }
        else
        {
            $result=0;
            $index=$indexInfo->user_rbtype_index;
            while($index>0){
                $val=$indexInfo->user_rbtype_buyrate;
                $low=$indexInfo->user_rbtype_lbuy;
                $result=$result + floor(($tranactionCount-$low) * $val *100) / 100;
                $index--;
                // dump($val);
                // dump($result);
                // $tranactionCount-=$low;
                if($index>0) {
                    $indexInfo=$this->getRakeBackInfo($index);
                    $tranactionCount=$indexInfo->user_rbtype_tbuy;
                }

            }
            $result=floor($result * 100)/100;

            return $result;
        }
    }

    /**
     * 用级别查询报表消息
     *
     * @param  $id
     * @author liu
     */

    public function getRakeBackInfo($type)
    {
        $model=$this->newitem();
        return $model->where('user_rbtype_index', $type)->first();
    }

    /**
     * 查询级别
     *
     * @param  $tranactionCount 返佣金额
     * @author liu
     */
    public function getUserBuyRakeBackBuyType($tranactionCount)
    {
        $model=$this->newitem();
        $indexInfo=$model->where('user_rbtype_lbuy', '<=', $tranactionCount);
        //->where('user_rbtype_tbuy','<',$tranactionCount)->first();
        if(empty($indexInfo->first())) {
            return 0;
        }
        else
        {
            $rakeBackInfo=$indexInfo->where('user_rbtype_tbuy', '>', $tranactionCount)->first();
        }
        //$rakeBackInfo=$this->getRakeBackInfo($index);
        if(empty($rakeBackInfo)) {
            $array=$model->get();
            $tBuyArray=array_pluck($array, 'user_rbtype_lbuy');
            $rakeBackInfo=$model->where('user_rbtype_lbuy', max($tBuyArray))->first();
        }

        if($rakeBackInfo->user_rbtype_enable == false) {
            return 0;
        }
        else
        {
            $result=0;
            $index=$rakeBackInfo->user_rbtype_buyrate;
            return $index;
        }
    }

    /**
     * 查询消费上限
     *
     * @param  $id
     * @author zhoutao
     */
    public function getUserTbuy($id)
    {
        $info = $this->get($id);
        if (empty($info)) {
            return 0;
        }
        return $info->user_rbtype_tbuy;
    }


    /**
     * 查询消费下限
     *
     * @param  $id 
     * @author zhoutao
     */
    public function getUserLbuy($id)
    {
        $info = $this->get($id);
        if (empty($info)) {
            return 0;
        }
        return $info->user_rbtype_lbuy;
    }

    public function getUserBuyRakeBackDirect($tranactionCount)
    {
        $model=$this->newitem();
        $indexInfo=$model->orderBy('user_rbtype_lbuy', 'desc')->where('user_rbtype_lbuy', '<=', $tranactionCount)->first();
        //->where('user_rbtype_tbuy','<',$tranactionCount)->first();
        if(empty($indexInfo)) {
            return 0;
        }

        if($indexInfo->user_rbtype_enable == false) {
            return 0;
        }
        else
        {
            $val=$indexInfo->user_rbtype_buyrate;
            $result=floor($tranactionCount * $val * 100) / 100;
            return $result;
        }
    }

    public function getUserBuyRakeBackPast($tranactionCount)
    {
        $model=$this->newitem();
        $indexInfo=$model->where('user_rbtype_lbuy', '<=', $tranactionCount);
        //->where('user_rbtype_tbuy','<',$tranactionCount)->first();
        if(empty($indexInfo->first())) {
            return 0;
        }
        else
        {
            $rakeBackInfo=$indexInfo->where('user_rbtype_tbuy', '>', $tranactionCount)->first();
        }
        //$rakeBackInfo=$this->getRakeBackInfo($index);
        if(empty($rakeBackInfo)) {
            $array=$model->get();
            $tBuyArray=array_pluck($array, 'user_rbtype_lbuy');
            $rakeBackInfo=$model->where('user_rbtype_lbuy', max($tBuyArray))->first();
        }

        if($rakeBackInfo->user_rbtype_enable == false) {
            return 0;
        }
        else
        {
            $result=0;
            $index=$rakeBackInfo->user_rbtype_index;
            while($index>0){
                $val=$rakeBackInfo->user_rbtype_buyrate;
                $low=$rakeBackInfo->user_rbtype_lbuy;
                $result=$result + floor(($tranactionCount-$low) * $val *100) / 100;
                $index--;
                if($index>1) {
                    $rakeBakeInfo=$this->getRakeBackInfo($index);
                    $tranactionCount=$rakeBackInfo->user_rbtype_tbuy;
                }

            }
            $result=floor($result * 100)/100;

            return $result;
        }
    }
}
