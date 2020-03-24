<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Cash\BankAccountData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData as UserCashJournalData;
use App\Data\User\UserData as userFac;
use App\Data\User\CashOrderData;
use App\Data\Report\ReportUserrbSubDayData;
use App\Http\Adapter\Report\ReportUserrbSubDayAdapter;
use Illuminate\Support\Facades\DB;

class RebateData extends IDatafactory
{

    const EVENT_REBATE_TYPE = 'Rebate_Check';

    /**
     * 发起返佣
     *
     * @param $reportNo 报表单号
     */
    public function createRebate($reportNo)
    {
        $lk = new LockData();
        $key = 'createRebate' . $reportNo;
        $lk->lock($key);

        // 更新报表
        $reportUserrbSubData=new ReportUserrbSubDayData();
        $reporAdapter = new ReportUserrbSubDayAdapter;
        $report=$reportUserrbSubData->getByNo($reportNo);

        DB::beginTransaction();
        if (!empty($report) && $report->report_enable_operation == 1) {
            $userid = $report->report_user;  //从报表中获取用户id
            $cash = $report->report_rbbuy_result; // 从报表中获取金额
            $pending = $cash; //从报表中获取在途金额d
            $adminid = $this->session->userid;
            $report->report_rbbuy_ispay=1;
            $report->report_rbbuy_payuser=$adminid;
            $report->report_rbbuy_paytime=date("Y-m-d h:i:s");
            //    $report->report_enable_operation=0;
            //    $reportModel=$reportUserrbSubData->newitem();
            //    $reporAdapter->saveToModel(false,$flse,$re);
            $reportUserrbSubData->save($report);

            $date = date('Y-m-d H:i:s');
            //插入系统流水 （平台账户） 可用减少 在途增加
            $cashBankData = new BankAccountData;
            $cashBankData->reduceCashIncreasePending(BankAccountData::TYPE_PLATFORM, $reportNo, $cash, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date);
            

            //插入系统流水 （托管账户） 在途增加
            $cashBankData->increasePending(BankAccountData::TYPE_ESCROW, $reportNo, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date);

            //写入用户流水 在途增加
            $userCashAccountData = new CashAccountData;
            $userCashAccountData->increasePending($reportNo, $pending, $userid, UserCashJournalData::REBATE_TYPE, UserCashJournalData::REBATE_STATUS, $date);
        }

        DB::commit();
        $lk->unlock($key);

       
    }


    /**
     * 返佣审核 成功
     *
     * @param  $reportNo 报表单号
     * 
     * 增加通知用户
     * @author zhoutao
     * @date   2017.11.1
     */
    public function rebateTrue($reportNo)
    {
        $lk = new LockData();
        $key = 'rebateConfirm' . $reportNo;
        $lk->lock($key);

        //更新报表
        $reportUserrbSubData=new ReportUserrbSubDayData();
        $report=$reportUserrbSubData->getByNo($reportNo);
        DB::beginTransaction();
        if (!empty($report) && $report->report_enable_operation == 1) {

            $userid = $report->report_user;  //从报表中获取用户id
            $cash = $report->report_rbbuy_result; // 从报表中获取金额
            $pending = $cash; //从报表中获取在途金额d
            $adminid = $this->session->userid;
            $report->report_rbbuy_chkuser=$adminid;
            $report->report_rbbuy_chktime=date("Y-m-d h:i:s");
            //$report['report_enable_operation']=false;
            //    $reportModel=$this->newitem();
            //    $reporAdapter->saveFromModel(true,$report,$reportmodel);
            $reportUserrbSubData->save($report);

                $adminid = $this->session->userid; //管理员id


                //插入系统流水（平台账户） 在途减少
                $date = date('Y-m-d H:i:s');
                $cashBankData = new BankAccountData;
                $cashBankData->reducePending(BankAccountData::TYPE_PLATFORM, $reportNo, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date);


                //插入系统流水（托管账户）在途减少 可用增加
                $cashBankData->increaseCashReducePending(BankAccountData::TYPE_ESCROW, $reportNo, $cash, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date);


                //插入用户流水 在途减少 可用增加
                $userCashAccountData = new CashAccountData;
                $userCashAccountRes = $userCashAccountData->increaseCashReducePending($reportNo, $cash, $pending, $userid, UserCashJournalData::REBATE_TYPE, UserCashJournalData::REBATE_STATUS, $date);

                //进行升级降级

                //查询消费金额
                $amount = $report->report_resultbuy;
                //消费金额是否达到消费上限

                //查询当前用户消费类型
                $userData = new userFac;
                $user = $userData->get($userid);
                $userLevel = $user->user_currentrbtype;
                $userTlevel = $user->user_nextrbtype;
                
                $rakeBackTypeData = new RakebackTypeData;
                $tbuy = $rakeBackTypeData->getUserTbuy($userLevel);
            if (intval($amount) >= intval($tbuy) && $tbuy != 0) {
                //达到上限，升级
                $user->user_currentrbtype += 1;

                $rakeBackType = $rakeBackTypeData->get($userTlevel + 1);
                if (!empty($rakebackType)) {
                    //说明有下一级别 更新下一级别
                    $user->user_nextrbtype += 1;
                }

                $userData->save($user);
            }

                //降级
            if ($userLevel > 1) {
                $lbuy = $rakeBackTypeData->getUserLbuy($userLevel);
                if (intval($amount) <= intval($lbuy) && $lbuy != 0) {
                    //达到下限，降级
                    $user->user_currentrbtype -= 1;

                    $rakeBackType = $rakeBackTypeData->get($userTlevel - 1);
                    if (!empty($rakebackType)) {
                        //说明有下一级别 更新下一级别
                        $user->user_nextrbtype -= 1;
                    }
                    $userData->save($user);
                }
            }

                //通知用户
                $this->AddEvent(self::EVENT_REBATE_TYPE, $userid, $reportNo);

                //写入资金账单
                $userCashOrderData = new CashOrderData();
                $balance = $userCashAccountRes['accountCash'];
                $cashOrderRes = $userCashOrderData->add($reportNo, $cash, CashOrderData::REBATE_TYPE, $balance, $userid);
                
                //通知用户
                $this->AddEvent(self::EVENT_REBATE_TYPE, $userid, $reportNo);

        }

        DB::commit();
        $lk->unlock($key);
    }

    /**
     * 返佣审核 失败
     *
     * @param $reportNo 报表单号
     */
    public function rebateFalse($reportNo)
    {
        $lk = new LockData();
        $key = 'rebateConfirm' . $reportNo;
        $lk->lock($key);

        //更新报表
        $reportUserrbSubData=new ReportUserrbSubDayData();
        $report=$reportUserrbSubData->getByNo($reportNo);
        $userid = $report->report_user;  //从报表中获取用户id
        $cash = $report->report_rbbuy_result; // 从报表中获取金额
        $pending = $cash; //从报表中获取在途金额
        $adminid = $this->session->userid;

        DB::beginTransaction();
        $report->report_rbbuy_chkuser=$adminid;
        $report->report_rbbuy_chktime=date("Y-m-d h:i:s");
        $report->report_rbbuy_ispay=0;
        //    $report->report_enable_operation=0;
        //    $reportModel=$this->newitem();
        //    $reporAdapter->saveFromModel(true,$report,$reportmodel);
        $reportUserrbSubData->save($report);
        // $adminid = $this->session->userid; //管理员id


        //插入系统流水（平台账户） 可用增加 在途减少
        $cashBankData = new BankAccountData;
        $date = date('Y-m-d H:i:s');
        $cashBankData->increaseCashReducePending(BankAccountData::TYPE_PLATFORM, $reportNo, $cash, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date);


        //插入系统流水（托管账户）在途减少
        $cashBankData->reducePending(BankAccountData::TYPE_ESCROW, $reportNo, $pending, CashJournalData::REBATE_TYPE, CashJournalData::REBATE_STATUS, $date);


        //插入用户流水 在途减少
        $userCashAccountData = new CashAccountData;
        $userCashAccountData->reducePending($reportNo, $pending, $userid, UserCashJournalData::REBATE_TYPE, UserCashJournalData::REBATE_STATUS, $date);

        DB::commit();
        $lk->unlock($key);
    }


}
