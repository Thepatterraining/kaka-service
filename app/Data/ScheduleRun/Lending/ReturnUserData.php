<?php
namespace App\Data\NotifyRun\Lending;
use App\Data\Schedule\IMinuteSchedule;
use App\Data\IDataFactory;
use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use App\Data\User\CashAccountData;
use App\Data\API\SMS\SmsVerifyFactory;
use App\Data\Lending\ReturnUserData as ReturnData;
use App\Data\Lending\LendingDocInfoData;
use App\Data\Coin\FrozenData;

class ReturnUserData extends IDatafactory implements IMinuteSchedule
{
    //
    /**
     * 查询到了归还时间的，进行归还
     *
     * @author zhoutao
     * @date   2017.11.10
     */
    public function minuterun()
    {
        $date = date('Y-m-d H:i:s');
        $lendingDocInfoData = new LendingDocInfoData;
        $frozenData = new FrozenData;
        $returnUserData=new ReturnData();
        $returns = $lendingDocInfoData->getReturns();
        foreach ($returns as $return) {
            $no = $return->lending_docno;
            $count = $return->lending_coin_ammount;
            $userid = $return->lending_lenduser;
            //解冻
            $frozen = $frozenData->getFrozenByJobNo($no);
            if (!empty($frozen)) {
                $frozenNo = $frozen->frozen_no;
                $frozenData->unFrozen($frozenNo, $count, $date);
                $returnUserData->userReturnSys($no);
                $returnUserData->userReturnSysTrue($no);
            }
        }
        
    }
}