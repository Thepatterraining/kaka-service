<?php
namespace App\Data\User;

use App\Data\IDataFactory;
use App\Data\Cash\BankAccountData;
use Illuminate\Support\Facades\DB;
use App\Data\Utils\DocNoMaker;
use App\Data\User\CashJournalData;
use App\Data\Trade\TranactionBuyData;
use App\Data\Trade\TranactionSellData;
use App\Data\Trade\RevokeBuyData;
use App\Data\Trade\CoinSellData;
use App\Data\Sys\LockData;

class CashFreezonDocData extends IDatafactory
{
    protected $modelclass = 'App\Model\User\CashFreezonDoc';

    protected $no = 'usercash_freezondoc_no';

    const FROZEN_TYPE = 'UCFDT01';
    const UNFROZEN_TYPE = 'UCFDT02';

    const APPLY_STATUS = 'UCFDS01';
    const SUCCESS_STATUS = 'UCFDS02';
    const FAIL_STATUS = 'UCFDS03';

    //类型 对应的方法
    private $_typeArray = [
        self::FROZEN_TYPE => 'frozen',
        self::UNFROZEN_TYPE => 'unFrozen',
    ];
    private $_docNo; //单号
    private $_date; //时间
    private $_amount; //金额

    /**
     * 插入数据
     *
     * @param $notes 说明
     * @param $userid 用户id
     * @param $accountid 账户id
     * @param $amount 金额
     * @param $type 类型
     * @param $status 状态
     */
    public function add($notes, $userid, $accountid, $amount, $type, $status)
    {
        $model = $this->newitem();
        $docNo = new DocNoMaker;
        $no = $docNo->Generate('UCFD');
        
        $model->usercash_freezondoc_no = $no;
        $model->usercash_freezondoc_notes = $notes;
        $model->usercash_freezondoc_userid = $userid;
        $model->usercash_freezondoc_accountid = $accountid;
        $model->usercash_freezondoc_amount = $amount;
        $model->usercash_freezondoc_type = $type;
        $model->usercash_freezondoc_status =  $status;
        $this->create($model);
        return $no;
    }

    /**
     * 创建冻结
     *
     * @param  $notes 说明
     * @param  $userid 用户id
     * @param  amount 金额
     * @author zhoutao
     * @date   2017.8.30
     * 
     * 去掉了金额
     * @author zhoutao
     * @date   2017.8.30
     */
    public function createFrozen($notes, $userid)
    {
        DB::beginTransaction();
        $userData = new UserData;
        $status = $userData->getUserStatus($userid);
        
        if ($status === UserData::USER_STATUS_NORMAL) {
            $date = date('Y-m-d H:i:s');
            $cashAccountData = new CashAccountData;
            $account = $cashAccountData->getUserCashInfo($userid);
            $accountid = $account->id;
            $amount = $account->account_cash;

            $no = $this->add($notes, $userid, $accountid, $amount, self::FROZEN_TYPE, self::APPLY_STATUS);
            DB::commit();
            return $no;
        }
        return '';
    }

    /**
     * 创建解冻
     *
     * @param  $notes 说明
     * @param  $userid 用户id
     * @param  amount 金额
     * @author zhoutao
     * @date   2017.8.30
     * 
     * 去掉了金额
     * @author zhoutao
     * @date   2017.8.30
     */
    public function createUnFrozen($notes, $userid)
    {
        DB::beginTransaction();
        $userData = new UserData;
        $status = $userData->getUserStatus($userid);
        
        if ($status === UserData::USER_STATUS_FROZEN) {
            $date = date('Y-m-d H:i:s');
            $cashAccountData = new CashAccountData;
            $account = $cashAccountData->getUserCashInfo($userid);
            $accountid = $account->id;
            $amount = $account->account_cash;

            $no = $this->add($notes, $userid, $accountid, $amount, self::UNFROZEN_TYPE, self::APPLY_STATUS);

            DB::commit();
            return $no;
        }
        return '';
    }

    /**
     * 审核成功
     *
     * @param  $no 单号
     * @author zhoutao
     * @date   2017.8.30
     * 
     * 增加锁
     * @author zhoutao
     * @date   2017.9.26
     * 
     * 修改redis key
     * @author zhoutao
     * @date   2017.10.10
     */
    public function trueFrozen($no)
    {
        $lk = new LockData();
        $key = 'confirmFrozen' . $no;
        $lk->lock($key);
        DB::beginTransaction();
        $info = $this->getByNo($no);
        $date = date('Y-m-d H:i:s');
        if (!empty($info)) {
            $userid = $info->usercash_freezondoc_userid;
            $type = $info->usercash_freezondoc_type;
            $amount = $info->usercash_freezondoc_amount;
            $status = $info->usercash_freezondoc_status;
            
            $this->_amount = $amount;
            $this->_date = $date;
            $this->_docNo = $no;
            
            if ($status == self::APPLY_STATUS) {
                $cashAccountData = new CashAccountData;
                if (count($this->_typeArray) > 0) {
                    $function = $this->_typeArray[$type];
                    $this->$function($userid);
                }
                
                $this->success($no, $date);
            }
             
        }
        
        
        DB::commit();
        $lk->unlock($key);
        return $no;
    }

    /**
     * 冻结
     *
     * @param  $userid 用户id
     * @author zhoutao
     * @date   2017.8.30
     */ 
    private function frozen($userid)
    {
        $this->session->userid = $userid;
        
        if (!empty($this->_docNo) && !empty($this->_amount) && !empty($this->_date)) {
            

            //撤销该用户所有挂单
            $buyData = new TranactionBuyData;
            $buyModel = $buyData->newitem();
            $buyModel->where('buy_userid', $userid)
                ->whereIn('buy_status', ['TB00','TB01'])
                ->chunk(
                    100, function ($buys) {
                        foreach ($buys as $buy) {
                            $revokeBuyData = new RevokeBuyData();
                            $revokeBuyData->revokeBuy($buy->buy_no, $this->_date);
                        }
                    }
                );
            $sellData = new TranactionSellData;
            $sellModel = $sellData->newitem();
            $sellModel->where('sell_userid', $userid)
                ->whereIn('sell_status', ['TS00','TS01'])
                ->chunk(
                    100, function ($sells) {
                        foreach ($sells as $sell) {
                            $transactionSellData = new CoinSellData();
                            $transactionSellData->revokeSell($sell->sell_no, $this->_date);
                        }
                    }
                );
            
            $cashAccountData = new CashAccountData;
            $account = $cashAccountData->getUserCashInfo($userid);
            $amount = $account->account_cash;

            
            $cashAccountData->reduceCashIncreasePending($this->_docNo, $amount, $amount, $userid, CashJournalData::FROZEN_TYPE, CashJournalData::FROZEN_STATUS, $this->_date);

            //更新表的金额
            $this->saveAmount($amount);

            //修改用户状态为冻结
            $userData = new UserData;
            $userData->saveStatus($userid, UserData::USER_STATUS_FROZEN);
        }
        
    }

    /**
     * 解冻
     *
     * @param  $userid 用户id
     * @author zhoutao
     * @date   2017.8.30
     */ 
    private function unFrozen($userid)
    {
        if (!empty($this->_docNo) && !empty($this->_amount) && !empty($this->_date)) {
            $cashAccountData = new CashAccountData;
            $cashAccountData->increaseCashReducePending($this->_docNo, $this->_amount, $this->_amount, $userid, CashJournalData::UNFROZEN_TYPE, CashJournalData::UNFROZEN_STATUS, $this->_date);
                        
            //修改用户状态为正常
            $userData = new UserData;
            $userData->saveStatus($userid, UserData::USER_STATUS_NORMAL);
        }
    }

    /**
     * 修改冻结金额
     *
     * @param  $amount 金额
     * @author zhoutao
     * @date   2017.8.30
     */ 
    private function saveAmount($amount)
    {
        if (!empty($this->_docNo)) {
            $info = $this->getByNo($this->_docNo);
            if (!empty($info)) {
                $info->usercash_freezondoc_amount = $amount;
                $this->save($info);
            }
        }
        
    }

    /**
     * 审核失败
     *
     * @param  $no 单号
     * @author zhoutao
     * @date   2017.8.30
     * 
     * 增加锁
     * @author zhoutao
     * @date   2017.9.26
     * 
     * 修改redis key
     * @author zhoutao
     * @date   2017.10.10
     */
    public function falseFrozen($no)
    {
        $lk = new LockData();
        $key = 'confirmFrozen' . $no;
        $lk->lock($key);
        DB::beginTransaction();
        $info = $this->getByNo($no);
        $date = date('Y-m-d H:i:s');
        if (!empty($info)) {
            $status = $info->usercash_freezondoc_status;
            if ($status == self::APPLY_STATUS) {
                $this->fail($no, $date);
            }   
            
        }
        
        
        DB::commit();
        $lk->unlock($key);
        return $no;
    }

    /**
     * 更新成功
     *
     * @param $no 单号
     * @param $date 时间
     */
    private function success($no, $date)
    {
        $info = $this->getByNo($no);
        if (!empty($info)) {
            $info->usercash_freezondoc_success = 1;
            $info->usercash_freezondoc_checkuser = $this->session->userid;
            $info->usercash_freezondoc_checktime = $date;
            $info->usercash_freezondoc_status = self::SUCCESS_STATUS;
            $this->save($info);
        }
    }

    /**
     * 更新失败
     *
     * @param $no 单号
     * @param $date 时间
     */
    private function fail($no, $date)
    {
        $info = $this->getByNo($no);
        if (!empty($info)) {
            $info->usercash_freezondoc_checkuser = $this->session->userid;
            $info->usercash_freezondoc_checktime = $date;
            $info->usercash_freezondoc_status = self::FAIL_STATUS;
            $this->save($info);
        }
    }
   
}
