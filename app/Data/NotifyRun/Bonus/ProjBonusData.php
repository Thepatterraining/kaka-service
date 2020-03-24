<?php
namespace App\Data\NotifyRun\Bonus;
use App\Data\Notify\INotifyData;
use App\Data\Report\ReportWithdrawalDayData;
use App\Data\Sys\LockData;
use App\Data\Project\ProjectInfoData;
use App\Data\Bonus\ProjectBonusItemData;
use App\Data\Bonus\ProjBonusData as BonusData;
use App\Data\Bonus\ProjDynamicData;
use App\Data\Utils\Formater;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData as UserCashJournalData;
use App\Data\User\CashOrderData;
use App\Data\Sys\CashJournalData;
use App\Data\Cash\BankAccountData;
use Illuminate\Support\Facades\DB;
use App\Data\Notify\INotifyDefault;
use App\Data\IDataFactory;
use App\Data\Bonus\ProjBonusItemData;

class ProjBonusData extends IDatafactory implements INotifyDefault
{
   const NEWUSER_BONUS_EVENT_TYPE = 'NewUser_Bonus_Check';

    /**
     * 审核成功后给用户发放分红
     *
     * @param  $data 数据
     * @author zhoutao
     * @date   2017.10.26
     * 
     * 如果新手项目的分红，通知状态改成新用户分红
     * @author zhoutao
     * @date   2017.11.14
     * 
     * 增加子表审核判断
     * @author zhoutao
     * @date   2017.11.16
     */
    public function notifyrun($data)
    {
        $bonusNo = $data['bonus_no'];
        $coinType = $data['bonus_proj'];
        $authDate = $data['bonus_authdate'];
        $dealCash = $data['bonus_dealcash'];
        $unit = $data['bonus_unit'];
        $status = $data['bonus_status'];
        $planCash = $data['bonus_plancash'];
        $planFee = $data['bonus_planfee'];
        $date = date('Y-m-d H:i:s');
        
        $lk = new LockData();
        $key = 'bonus' . $bonusNo;
        $lk->lock($key);

        DB::beginTransaction();

        $projectInfoData=new ProjectInfoData();
        $projBonusItemData = new ProjBonusItemData;
        $bonusData=new BonusData();

        $projectInfo=$projectInfoData->getByNo($coinType);
        $square=$projectInfo->project_coinammount;
        $projectType = $projectInfo->project_type;

        $newUserType = config('activity.newUserTypeid');
        $eventType = ProjBonusItemData::EVENT_TYPE;
        if ($projectType == $newUserType) {
            $eventType = self::NEWUSER_BONUS_EVENT_TYPE;
        }

        if ($status == BonusData::SUCCESS_STATUS) {
            //写入项目公告
            $newsNo = 1;                                           

            //写入项目动态
            $dynamicData = new ProjDynamicData;
            $dynamicData->add($coinType, ProjDynamicData::BONUS_TYPE, $newsNo);

            $bonusItems = $projBonusItemData->getPreBonusItems($bonusNo, $coinType, $authDate);

            //查询确权单信息 循环用户发分红
            foreach ($bonusItems as $bonusItem) {
                $success = $bonusItem->bonus_success;
                if ($success == 0) {
                    $count = $bonusItem->bonus_count; //确权时候该用户该代币的数量
                    if ($projectType == $newUserType) {
                        $pending = Formater::floor(($planCash-$planFee)); //给用户发的分红金额 floor 保留两位
                    } else {
                        $pending = Formater::floor(($planCash-$planFee) * $count /$square); //给用户发的分红金额 floor 保留两位
                    }
                    $userid = $bonusItem->bonus_userid; //用户id
                    $cash = $pending;
                    //只有大于最小单位的才给分红
                    if (bccomp($count, $unit, 9) >= 0) {
                        //插入用户流水 在途减少 可用增加
                        $userCashAccountData = new CashAccountData;
                        $userCashAccountRes = $userCashAccountData->increaseCashReducePending($bonusNo, $cash, $pending, $userid, UserCashJournalData::BONUES_TYPE, UserCashJournalData::BONUS_STATUS, $date);
                        //更新分红子表为成功
                        $bonusItemData = new ProjBonusItemData;
                        $bonusItemid = $bonusItemData->saveSuccess($bonusNo, $userid, $coinType, $authDate);

                        //写入资金账单
                        $userCashOrderData = new CashOrderData();
                        $balance = $userCashAccountRes['accountCash'];
                        $cashOrderRes = $userCashOrderData->add($bonusNo, $cash, CashOrderData::BONUS_TYPE, $balance, $userid);

                        //通知用户
                        $this->AddEvent($eventType, $userid, $bonusItemid);
                        
                    }
                }
                
            }

            //插入系统流水（平台账户） 在途减少
            $cashBankData = new BankAccountData;
            $cashBankData->reducePending(BankAccountData::TYPE_PLATFORM, $bonusNo, $dealCash, CashJournalData::BONUS_TYPE, CashJournalData::BONUS_STATUS, $date);

        }
        DB::commit();
        $lk->unlock($key);
    }
}
