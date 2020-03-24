<?php
namespace App\Data\SysCash;

use App\Data\IDataFactory;
use App\Data\Cash\BankAccountData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData as UserCashJournalData;
use App\Data\User\UserData;
use App\Data\User\CashOrderData;
use App\Data\Report\ReportUserrbSubDayData;
use App\Http\Adapter\Report\ReportUserrbSubDayAdapter;
use App\Data\Sys\CashJournalData;

class Pay2User extends IDatafactory
{

   
    public function createPay($userid,$money,$docNo="",$docType = CashJournalData::REBATE_TYPE)
    {
     
            $date = date('Y-m-d H:i:s');
            //插入系统流水 （平台账户） 可用减少 在途增加
            $cashBankData = new BankAccountData;
            $cashBankData->reduceCashIncreasePending(
                BankAccountData::TYPE_PLATFORM,
                $docNo,
                $money,
                $money,
                $docType,
                CashJournalData::REBATE_STATUS, $date
            );
            //插入系统流水 （托管账户） 在途增加
            $cashBankData->increasePending(
                BankAccountData::TYPE_ESCROW,
                $docNo,
                $money,
                $docType, 
                CashJournalData::REBATE_STATUS, $date
            );

            //写入用户流水 在途增加
            $userCashAccountData = new CashAccountData;
            $userCashAccountData->increasePending(
                $docNo,
                $money,
                $userid,
                $docType,
                UserCashJournalData::REBATE_STATUS, $date
            );
      
    }


 
    public function confirmPay($userid,
        $money,
        $docNo="",
        $docType = CashJournalData::REBATE_TYPE
    ) {
        

                $adminid = $this->session->userid; //管理员id


                //插入系统流水（平台账户） 在途减少
                $date = date('Y-m-d H:i:s');
                $cashBankData = new BankAccountData;
                $cashBankData->reducePending(
                    BankAccountData::TYPE_PLATFORM,
                    $docNo,
                    $money,
                    $docType,
                    CashJournalData::REBATE_STATUS,
                    $date
                );
                //插入系统流水（托管账户）在途减少 可用增加
                $cashBankData->increaseCashReducePending(
                    BankAccountData::TYPE_ESCROW,
                    $docNo,
                    $money,
                    $money,
                    $docType, 
                    CashJournalData::REBATE_STATUS, $date
                );
                //插入用户流水 在途减少 可用增加
                $userCashAccountData = new CashAccountData;
                $userCashAccountRes = $userCashAccountData->increaseCashReducePending(
                    $docNo,
                    $money,
                    $money,
                    $userid,
                    $docType,
                    UserCashJournalData::REBATE_STATUS,
                    $date
                );

                //进行升级降级

                //查询消费金
                //消费金额是否达到消费上限

                //查询当前用户消费类型
                $userData = new UserData;
              
                //写入资金账单
                $userCashOrderData = new CashOrderData();
                $balance = $userCashAccountRes['accountCash'];
                $cashOrderRes = $userCashOrderData->add(
                    $docNo,
                    $money, 
                    CashOrderData::REBATE_TYPE, 
                    $balance, 
                    $userid
                );

    }

 
    public function refusePay($userid,
        $money,
        $docNo="",
        $docType = CashJournalData::REBATE_TYPE
    ) {
        //更新报表
        $adminid = $this->session->userid;
    


        //插入系统流水（平台账户） 可用增加 在途减少
        $cashBankData = new BankAccountData;
        $date = date('Y-m-d H:i:s');
        $cashBankData->increaseCashReducePending(
            BankAccountData::TYPE_PLATFORM,
            $docNo,
            $money,
            $money,
            $docType, 
            CashJournalData::REBATE_STATUS, $date
        );


        //插入系统流水（托管账户）在途减少
        $cashBankData->reducePending(
            BankAccountData::TYPE_ESCROW,
            $docNo,
            $money,
            $docType, 
            CashJournalData::REBATE_STATUS,
            $date
        );


        //插入用户流水 在途减少
        $userCashAccountData = new CashAccountData;
        $userCashAccountData->reducePending(
            $docNo,
            $money,
            $userid,
            $docType,
            UserCashJournalData::REBATE_STATUS, $date
        );
    }
}
