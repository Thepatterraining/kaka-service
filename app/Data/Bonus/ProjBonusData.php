<?php
namespace App\Data\Bonus;

use App\Data\IDataFactory;
use App\Data\Sys\CashJournalData;
use App\Data\Utils\DocNoMaker;
use App\Data\Cash\BankAccountData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData as UserCashJournalData;
use Illuminate\Support\Facades\DB;
use App\Data\Report\ReportUserCoinItemDayData;
use App\Data\Report\ReportUserCoinDayData;
use App\Data\Product\InfoData as ProductInfoData;
use App\Data\User\CashOrderData;
use App\Data\Utils\Formater;
use App\Http\Adapter\Bonus\ProjBonusItemAdapter;
use App\Data\User\UserData;
use App\Data\User\UserTypeData;
use App\Data\Sys\LockData;
use App\Data\Project\ProjectInfoData;
use App\Data\Notify\INotifyDefault;
// use App\Data\Notify\INotifySMS;


class ProjBonusData extends IDatafactory //implements INotifyDefault
{

    protected $modelclass = 'App\Model\Bonus\ProjBonus';

    protected $no = 'bonus_no';

    const APPLY_STATUS = 'PBS01';
    const SUCCESS_STATUS = 'PBS02';
    const FAIL_STATUS = 'PBS03';

    const NEWUSER_BONUS_EVENT_TYPE = 'NewUser_Bonus_Check';

    /**
     * 写入分红表信息
     *
     * @param  $coinType 代币类型
     * @param  $rightNo 确权单号
     * @param  $authDate 确权时间
     * @param  $amount 总金额
     * @param  $planfee 管理费
     * @param  $dealCash 实际分红金额
     * @param  $dealFee 实际管理费
     * @param  $cash 分红金额
     * @param  $unit 最小单位
     * @param  $holdings 持币总用户
     * @param  $distributeCount 达到条件用户
     * @param  $status 状态
     * @param  $date 发起时间
     * @author zhoutao
     */
    public function add($coinType, $rightNo, $authDate, $amount, $planfee, $dealCash, $dealFee, $cash, $unit, $holdings, $distributeCount, $status, $date, $starttime, $endtime, $bonusInstalment)
    {

        $docNo = new DocNoMaker;
        $no = $docNo->Generate('CBN');

        $model = $this->newitem();
        $model->bonus_no = $no;
        $model->bonus_proj = $coinType;
        $model->bonus_authdate = $authDate;
        $model->bonus_plancash = $amount;
        $model->bonus_planfee = $planfee;
        $model->bonus_dealcash = $dealCash;
        $model->bonus_dealfee = $dealFee;
        $model->bonus_cash = $cash;
        $model->bonus_unit = $unit;
        $model->bonus_holdings = $holdings;
        $model->bonus_distributecount = $distributeCount;
        $model->bonus_status = $status;
        $model->bonus_time = $date;
        $model->bonus_rightno = $rightNo;
        $model->bonus_starttime = $starttime;
        $model->bonus_endtime = $endtime;
        $model->bonus_instalment = '第' . $bonusInstalment . '期';
        $this->create($model);
        return $no;
    }

    /**
     * 开始分红
     *
     * @param  $rightNo 确权单号
     * @param  $amount 分红总金额
     * @param  $planfee 管理费用
     * @param  $unit 最小单位
     * @param  $starttime 开始时间
     * @param  $endtime 结束时间
     * @author zhoutao
     * 
     * 1 查询确权单信息
     * 2 循环给用户发分红
     * 3 写入分红表信息
     * 4 写入系统流水
     * 
     * 查询项目总代币量改用projectInfoData
     * @author zhoutao
     * @date   2017.10.19
     */
    public function createBonus($rightNo, $authDate,$amount, $planfee, $unit, $starttime, $endtime,$coinType, $bonusInstalment, $bonusCycle)
    {
        $lk = new LockData();
        $key = 'createBonus' . $coinType;
        $lk->lock($key);

        $date = date('Y-m-d H:i:s');
        $dealCash = 0; //初始化实际金额
        $reportUseCoinItemDayData=new ReportUserCoinItemDayData();
        $reportUseCoinDayData=new ReportUserCoinDayData();
        $projectInfoData=new ProjectInfoData();
        //查询确权单信息
        //$coinType = 'KKC-BJ0001'; //代币类型
        $userCoinInfo=$reportUseCoinItemDayData->getHolding($authDate, $coinType);
        $projectInfo=$projectInfoData->getByNo($coinType);
        $square=$projectInfo->project_coinammount;//['space'];
        $projectType = $projectInfo->project_type;

        // $authDate = $date; //确权时间
        $holdings = count($userCoinInfo); //持币总用户
        $distributeCount = 0; //符合条件用户
        $rightStatus = true; //确权单是否审批
        $bonusNo = '';

        $newUserType = config('activity.newUserTypeid');

        DB::beginTransaction(); 
        if ($rightStatus && $planfee < $amount) {
            //写入分红
            $dealFee = 0;
            $cash = $amount - $planfee;
            $bonusNo = $this->add($coinType, $rightNo, $authDate, $amount, $planfee, $dealCash, $dealFee, $cash, $unit, $holdings, $distributeCount, ProjBonusData::APPLY_STATUS, $date, $starttime, $endtime, $bonusInstalment);

            //写入用户流水 在途增加
            $userCashAccountData = new CashAccountData;
            //查出要给哪些用户发放分红 然后循环发放
            foreach($userCoinInfo as $value){
                $userInfo=$reportUseCoinDayData->getReportByNo($value->report_no);               
                $count = $value->report_holding; //确权时候该用户该代币的数量
                
                if ($projectType == $newUserType) {
                    $pending = Formater::floor(($amount-$planfee)); //给用户发的分红金额 floor 保留两位
                } else {
                    $pending = Formater::floor(($amount-$planfee) * $count /$square); //给用户发的分红金额 floor 保留两位
                }
              
                $userid = $userInfo->report_user; //用户id

                //只有大于最小单位的才给分红
                if (bccomp($count, $unit, 9) >=0) {
                    $dealCash += $pending; //累计增加用户金额
                    $userCashAccountData->increasePending($bonusNo, $pending, $userid, UserCashJournalData::BONUES_TYPE, UserCashJournalData::BONUS_STATUS, $date);
                    $distributeCount++;
                    //写入分红子表
                    $bonusItemData = new ProjBonusItemData;
                    $bonusItemData->add($bonusNo, $coinType, $authDate, $userid, $count, $pending, $bonusCycle);
                }
            
                
            }

            //更新实际分红金额
            $dealFee = $amount - $dealCash;
            $this->saveDealCash($bonusNo, $dealCash, $dealFee);

            //更新符合条件用户
            $this->saveDistributeCount($bonusNo, $distributeCount);
            

            //插入系统流水（平台账户） 在途增加 可用减少
            $date = date('Y-m-d H:i:s');
            $cashBankData = new BankAccountData;
            $cashBankData->reduceCashIncreasePending(BankAccountData::TYPE_PLATFORM, $bonusNo, $dealCash, $dealCash, CashJournalData::BONUS_TYPE, CashJournalData::BONUS_STATUS, $date);
        }
        DB::commit();
        $lk->unlock($key);
        
        return $bonusNo;
        
    }

    /**
     * 更新符合条件用户
     *
     * @param  $bonusNo 分红单号
     * @param  $distributeCount 符合条件用户
     * @author zhoutao
     */
    public function saveDistributeCount($bonusNo,$distributeCount)
    {
        $bonus = $this->getByNo($bonusNo);
        $bonus->bonus_distributecount = $distributeCount;
        $this->save($bonus);
    }

    /**
     * 更新分红的实际分红金额
     *
     * @param  $bonusNo 分红单号
     * @param  $dealCash 实际分红金额
     * @author zhoutao
     */
    public function saveDealCash($bonusNo,$dealCash,$dealFee)
    {
        $bonus = $this->getByNo($bonusNo);
        $bonus->bonus_dealcash = $dealCash;
        $bonus->bonus_dealfee = $dealFee;
        $this->save($bonus);
    }

    /**
     * 分红审核成功
     *
     * @param  $bonusNo 分红单号
     * @author zhoutao
     * 
     * 1 查询分红单信息
     * 2 写入项目公告
     * 3 写入项目动态
     * 4 查询确权 循环用户发分红
     * 5 更新分红子表
     * 6 插入系统流水
     * 7 更新分红为成功
     * 
     * 增加锁
     * @author zhoutao
     * @date   2017.9.26
     * 
     * 修改redis key 
     * @author zhoutao
     * @date   2017.10.10
     * 
     * 查询项目总代币量改用projectInfoData
     * @author zhoutao
     * @date   2017.10.19
     * 
     * 只更新分红表为成功
     * @author zhoutao
     * @date   2017.10.26
     */
    public function bonusTrue($bonusNo)
    {
        $lk = new LockData();
        $key = 'bonusConfirm' . $bonusNo;
        $lk->lock($key);
        DB::beginTransaction();
        $reportUseCoinItemDayData=new ReportUserCoinItemDayData();
        $reportUseCoinDayData=new ReportUserCoinDayData();
        $projectInfoData=new ProjectInfoData();
        //查询分红单信息
        $bonus = $this->getByNo($bonusNo);
        $date = date('Y-m-d H:i:s');
        $rightNo = $bonus->bonus_rightno; //确权单号
        $authDate = $bonus->bonus_authdate; //确权时间
        $dealCash = $bonus->bonus_dealcash;
        $status = $bonus->bonus_status;
        $coinType = $bonus->bonus_proj;
        $unit = $bonus->bonus_unit;

        $userCoinInfo=$reportUseCoinItemDayData->getHolding($authDate, $coinType);
        $projectInfo=$projectInfoData->getByNo($coinType);
        $square=$projectInfo->project_coinammount;//['space'];

        
        if ($status == ProjBonusData::APPLY_STATUS) {

            //更新分红为成功
            $this->saveSuccess($bonusNo);
        }

        DB::commit();
        $lk->unlock($key);
        
    
    }

    /**
     * 分红成功
     *
     * @param  $bonus 分红单号
     * @author zhoutao
     */
    public function saveSuccess($bonusNo)
    {
        $info = $this->getByNo($bonusNo);
        $info->bonus_status = ProjBonusData::SUCCESS_STATUS;
        $info->bonus_chkuserid = $this->session->userid;
        $info->bonus_chktime = date('Y-m-d H:i:s');
        $this->save($info);
    }

    /**
     * 分红审核失败
     *
     * @param  $bonusNo 分红单号
     * @author zhoutao
     * 
     * 1 查询分红单信息
     * 2 查询确权信息 循环用户退回分红
     * 3 插入系统流水
     * 4 更新分红失败
     * 
     * 增加锁
     * @author zhoutao
     * @date   2017.9.26
     * 
     * 修改redis key 
     * @author zhoutao
     * @date   2017.10.10
     * 
     * 查询项目总代币量改用projectInfoData
     * @author zhoutao
     * @date   2017.10.19
     */
    public function bonusFalse($bonusNo)
    {
        $lk = new LockData();
        $key = 'bonusConfirm' . $bonusNo;
        $lk->lock($key);
        DB::beginTransaction();
        //查询分红单信息
        $reportUseCoinItemDayData=new ReportUserCoinItemDayData();
        $reportUseCoinDayData=new ReportUserCoinDayData();
        $projectInfoData=new ProjectInfoData();
        $bonus = $this->getByNo($bonusNo);
        $date = date('Y-m-d H:i:s');
        $rightNo = $bonus->bonus_rightno; //确权单号
        $authDate = $bonus->bonus_authdate; //确权时间
        $dealCash = $bonus->bonus_dealcash;
        $status = $bonus->bonus_status;
        $coinType = $bonus->bonus_proj;
        $unit = $bonus->bonus_unit;

        $userCoinInfo=$reportUseCoinItemDayData->getHolding($authDate, $coinType);
        $projectInfo=$projectInfoData->getByNo($coinType);
        $square=$projectInfo->project_coinammount;//['space'];

        
        if ($status == ProjBonusData::APPLY_STATUS) {

            //查询确权单信息 循环用户发分红
            foreach($userCoinInfo as $value){
                $userInfo=$reportUseCoinDayData->getReportByNo($value->report_no);
                $count = $value->report_holding; //确权时候该用户该代币的数量
                $pending = floor((($bonus->bonus_plancash-$bonus->bonus_planfee) * $count /$square) *100) / 100; //给用户发的分红金额 floor 保留两位
                $userid = $userInfo->report_user; //用户id
                //只有大于最小单位的才给分红
                if (bccomp($count, $unit, 9) === 1) {
                    //插入用户流水 在途减少
                    $userCashAccountData = new CashAccountData;
                    $userCashAccountData->reducePending($bonusNo, $pending, $userid, UserCashJournalData::BONUES_TYPE, UserCashJournalData::BONUS_STATUS, $date);
                }
            }

            //插入系统流水（平台账户） 可用增加 在途减少
            $date = date('Y-m-d H:i:s');
            $cashBankData = new BankAccountData;
            $cashBankData->increaseCashReducePending(BankAccountData::TYPE_PLATFORM, $bonusNo, $dealCash, $dealCash, CashJournalData::BONUS_TYPE, CashJournalData::BONUS_STATUS, $date);


            //更新分红为失败
            $this->saveFail($bonusNo);
        }

        DB::commit();
        $lk->unlock($key);
    }

    /**
     * 分红失败
     *
     * @param  $bonusNo 分红单号
     * @author zhoutao
     */
    public function saveFail($bonusNo)
    {
        $info = $this->getByNo($bonusNo);
        $info->bonus_status = ProjBonusData::FAIL_STATUS;
        $info->bonus_chkuserid = $this->session->userid;
        $info->bonus_chktime = date('Y-m-d H:i:s');
        $this->save($info);
    }

    /**
     * 查询产品详细的分红列表
     *
     * @param  $productNo 产品号
     * @param  $pageIndex 页码
     * @param  $pageSize 数量
     * @author zhoutao
     * @date   2017.9.22
     * 
     * 加入判空返回空数组
     * @author zhoutao
     * @date   2017.9.24
     * 
     * 修改判空返回
     * @author zhoutao
     * @date   2017.9.25
     * 
     * 增加成功的条件
     * @author zhoutao
     * @date   2017.9.26
     * 
     * 把产品单号改成代币类型
     * @param  $coinType 
     * @author zhoutao
     * @date   2017.10.17
     * 
     * 查询比例因子改用projectInfoData
     * @author zhoutao
     * @date   2017.10.19
     * 
     * 改成保留两位小数
     * @author zhoutao
     * @date   2017.10.24
     */
    public function getBonus($coinType, $pageIndex, $pageSize)
    {
        //查询产品的代币类型
        $productData = new ProductInfoData;
        $bonusItemData = new ProjBonusItemData;
        $bonusItemAdapter = new ProjBonusItemAdapter;
        $userData = new UserData;
        $userTypeData = new UserTypeData;
        $projectInfoData = new ProjectInfoData;

        if ($coinType == null) {
            $res['totalSize'] = 0;
            $res['items'] = [];
            $res['pageIndex'] = $pageIndex;
            $res['pageSize'] = $pageSize;
            $res['pageCount'] = 1;
            return $res;
        }
        $model = $this->modelclass;
        $where['bonus_proj'] = $coinType;
        $where['bonus_status'] = self::SUCCESS_STATUS;
        $bonus = $model::where($where)->orderBy('bonus_authdate', 'desc')->first();
        if (empty($bonus)) {
            $res['totalSize'] = 0;
            $res['items'] = [];
            $res['pageIndex'] = $pageIndex;
            $res['pageSize'] = $pageSize;
            $res['pageCount'] = 1;
            return $res;
        }
        $bonusNo = $bonus->bonus_no;
        //第几期分红
        $bonusInstalment = $bonus->bonus_instalment;
        $filters['bonus_no'] = $bonusNo;
        $filters['bonus_success'] = 1;
        $filters['bonus_proj'] = $coinType;
        $bonusItems = $bonusItemData->query($filters, $pageSize, $pageIndex);

        $res = [];
        if (count($bonusItems['items']) > 0) {
            foreach ($bonusItems['items'] as $bonusItem) {
                $bonusItem = $bonusItemAdapter->getDataContract($bonusItem, ['userid','count']);
                //获取因子
                $projectInfo = $projectInfoData->getByNo($coinType);
                $scale = $projectInfo->project_scale;

                $user = $userData->getUser($bonusItem['userid']);
                $mobile = $user->user_mobile;
                
                $bonusItem['count'] /= $scale;
                $bonusItem['count'] = Formater::floor($bonusItem['count'], 2);
                $bonusItem['mobile'] = substr_replace($mobile, "****", 3, -4);
                $bonusItem['instalment'] = $bonusInstalment;
                $bonusItem['status'] = '已发放';
                $res[] = $bonusItem;
                $bonusItems['items'] = $res;
            }
        }
        return $bonusItems;
    }

    // public function notifycreateddefaultrun($data)
    // {

    // }

    // /**
    //  * 审核成功后给用户发放分红
    //  * @param $data 数据
    //  * @author zhoutao
    //  * @date 2017.10.26
    //  * 
    //  * 如果新手项目的分红，通知状态改成新用户分红
    //  * @author zhoutao
    //  * @date 2017.11.14
    //  * 
    //  * 增加子表审核判断
    //  * @author zhoutao
    //  * @date 2017.11.16
    //  */
    // public function notifysaveddefaultrun($data)
    // {
    //     $bonusNo = $data['bonus_no'];
    //     $coinType = $data['bonus_proj'];
    //     $authDate = $data['bonus_authdate'];
    //     $dealCash = $data['bonus_dealcash'];
    //     $unit = $data['bonus_unit'];
    //     $status = $data['bonus_status'];
    //     $planCash = $data['bonus_plancash'];
    //     $planFee = $data['bonus_planfee'];
    //     $date = date('Y-m-d H:i:s');
        
    //     $lk = new LockData();
    //     $key = 'bonus' . $bonusNo;
    //     $lk->lock($key);

    //     DB::beginTransaction();

    //     $projectInfoData=new ProjectInfoData();
    //     $projBonusItemData = new ProjBonusItemData;

    //     $projectInfo=$projectInfoData->getByNo($coinType);
    //     $square=$projectInfo->project_coinammount;
    //     $projectType = $projectInfo->project_type;

    //     $newUserType = config('activity.newUserTypeid');
    //     $eventType = ProjBonusItemData::EVENT_TYPE;
    //     if ($projectType == $newUserType) {
    //         $eventType = self::NEWUSER_BONUS_EVENT_TYPE;
    //     }

    //     if ($status == ProjBonusData::SUCCESS_STATUS) {
    //         //写入项目公告
    //         $newsNo = 1;                                           

    //         //写入项目动态
    //         $dynamicData = new ProjDynamicData;
    //         $dynamicData->add($coinType, ProjDynamicData::BONUS_TYPE, $newsNo);

    //         $bonusItems = $projBonusItemData->getPreBonusItems($bonusNo, $coinType, $authDate);

    //         //查询确权单信息 循环用户发分红
    //         foreach($bonusItems as $bonusItem){
    //             $success = $bonusItem->bonus_success;
    //             if ($success == 0) {
    //                 $count = $bonusItem->bonus_count; //确权时候该用户该代币的数量
    //                 if ($projectType == $newUserType) {
    //                     $pending = Formater::floor(($planCash-$planFee)); //给用户发的分红金额 floor 保留两位
    //                 } else {
    //                     $pending = Formater::floor(($planCash-$planFee) * $count /$square); //给用户发的分红金额 floor 保留两位
    //                 }
    //                 $userid = $bonusItem->bonus_userid; //用户id
    //                 $cash = $pending;
    //                 //只有大于最小单位的才给分红
    //                 if (bccomp($count, $unit, 9) >= 0) {
    //                     //插入用户流水 在途减少 可用增加
    //                     $userCashAccountData = new CashAccountData;
    //                     $userCashAccountRes = $userCashAccountData->increaseCashReducePending($bonusNo,$cash,$pending,$userid,UserCashJournalData::BONUES_TYPE,UserCashJournalData::BONUS_STATUS,$date);
    //                     //更新分红子表为成功
    //                     $bonusItemData = new ProjBonusItemData;
    //                     $bonusItemid = $bonusItemData->saveSuccess($bonusNo,$userid,$coinType,$authDate);

    //                     //写入资金账单
    //                     $userCashOrderData = new CashOrderData();
    //                     $balance = $userCashAccountRes['accountCash'];
    //                     $cashOrderRes = $userCashOrderData->add($bonusNo, $cash, CashOrderData::BONUS_TYPE, $balance, $userid);

    //                     //通知用户
    //                     $this->AddEvent($eventType, $userid, $bonusItemid);
                        
    //                 }
    //             }
                
    //         }

    //         //插入系统流水（平台账户） 在途减少
    //         $cashBankData = new BankAccountData;
    //         $cashBankData->reducePending(BankAccountData::TYPE_PLATFORM,$bonusNo,$dealCash,CashJournalData::BONUS_TYPE, CashJournalData::BONUS_STATUS,$date);

    //     }
    //     DB::commit();
    //     $lk->unlock($key);
    // }

    // public function notifydeleteddefaultrun($data)
    // {

    // }

}
