<?php
namespace App\Data\User;

use App\Data\IDataFactory;
use App\Http\Adapter\User\CashAccountAdapter;
use Illuminate\Support\Facades\Log;
use App\Data\User\CashJournalData;
use \Exception;
use App\Data\Sys\LockData;

class CashAccountData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\User\CashAccount';

    protected $no = 'account_userid';
    
    const ERROR_MSG = '账户异常，请联系管理员';

    /**
     * 注册的时候增加现金账户
     *
     * @param   $userId 用户id
     * @author  zhoutao
     * @version 0.1
     */
    public function regAddAccount($userId)
    {
        $model = $this->newitem();
        $model->account_userid = $userId;
        return $this->create($model);
    }

    /**
     * 更新用户现金余额 增加在途 减少余额
     *
     * @param   $amount 要增加的金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function saveUserPendingAccount($amount, $date = null, $userid = '')
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        if (empty($userid)) {
            $userid = $this->session->userid;
        }
        $modelclass = $this->newitem();
        $accountInfo = $modelclass::where('account_userid', $userid)->lockforupdate()->first();
        $accountPending = $accountInfo->account_pending + $amount;
        $accountCash = $accountInfo->account_cash - $amount;
        $accountInfo->account_pending = $accountPending;
        $accountInfo->account_cash = $accountCash;
        $accountInfo->account_change_time = $date;

        //判断在途为负则返回错误
        if ($accountInfo->account_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        $res['res'] = $accountInfo->save();
        return $res;
    }

    /**
     * 更新用户现金余额 增加在途 减少余额
     *
     * @param   $amount 要增加的金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function saveUserPendingAccountTwo($amount, $cash, $date = null, $userid = '')
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        if (empty($userid)) {
            $userid = $this->session->userid;
        }
        $modelclass = $this->newitem();
        $accountInfo = $modelclass::where('account_userid', $userid)->lockforupdate()->first();
        $accountPending = $accountInfo->account_pending + $amount;
        $accountCash = $accountInfo->account_cash - $cash;
        $accountInfo->account_pending = $accountPending;
        $accountInfo->account_cash = $accountCash;
        $accountInfo->account_change_time = $date;

        //判断在途为负则返回错误
        if ($accountInfo->account_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        $res['res'] = $accountInfo->save();
        return $res;
    }

    /**
     * 更新用户现金余额 增加余额 减少在途
     *
     * @param   $amount 要增加的金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function saveUserCashAccount($amount, $userid = null, $date = null)
    {
        if ($userid === null) {
            $userid = $this->session->userid;
        }
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $modelclass = $this->newitem();
        $accountInfo = $modelclass::where('account_userid', $userid)->lockforupdate()->first();
        $accountPending = $accountInfo->account_pending - $amount;
        $accountCash = $accountInfo->account_cash + $amount;
        $accountInfo->account_pending = $accountPending;
        $accountInfo->account_cash = $accountCash;
        $accountInfo->account_change_time = $date;

        //判断在途为负则返回错误
        if ($accountInfo->account_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        $res['res'] = $accountInfo->save();
        return $res;
    }


    /**
     * 更新用户现金余额 增加余额
     *
     * @param   $amount 要增加的金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function saveUserCashAccountTwo($amount, $userid = null, $date = null)
    {
        if ($userid === null) {
            $userid = $this->session->userid;
        }
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $modelclass = $this->newitem();
        $accountInfo = $modelclass->where('account_userid', $userid)->lockforupdate()->first();
        $accountPending = $accountInfo->account_pending;
        $accountCash = $accountInfo->account_cash + $amount;
        $accountInfo->account_pending = $accountPending;
        $accountInfo->account_cash = $accountCash;
        $accountInfo->account_change_time = $date;

        //判断在途为负则返回错误
        if ($accountInfo->account_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        $res['res'] = $accountInfo->save();
        return $res;
    }

    /**
     * 更新用户在途余额
     *
     * @param   $amount 要增加的金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function savePendingCash($amount)
    {
        $where['account_userid'] = $this->session->userid;
        $model = $this->findForUpdate($where);
        $accountPending = $model->account_pending + $amount;
        $accountCash = $model->account_cash;
        $model->account_pending = $accountPending;
        $model->account_change_time = date('Y-m-d H:i:s');

        //判断在途为负则返回错误
        if ($model->account_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['res'] = $model->save();
        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        return $res;
    }

    /**
     * 更新用户在途余额
     *
     * @param   $amount 要增加的金额
     * @param   $userid 用户id
     * @param   $date 日期
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了错误返回
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function savePendingShao($amount, $userid = null, $date = null)
    {
        if ($userid === null) {
            $userid = $this->session->userid;
        }
        if ($date === null) {
            $date = date('Y-m-d H:i:s');
        }
        $where['account_userid'] = $userid;
        $model = $this->findForUpdate($where);
        $accountPending = bcsub(strval($model->account_pending), strval($amount), 2);
        $accountCash = $model->account_cash;
        $model->account_pending = $accountPending;
        $model->account_change_time = $date;

        //判断在途为负则返回错误
        if ($model->account_pending < 0) {
            throw new Exception(self::ERROR_MSG);
        }

        $res['res'] = $model->save();
        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        return $res;
    }

    /**
     * 查询用户现金信息
     *
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserCashInfo($userid = '')
    {
        if (empty($userid)) {
            $userid = $this->session->userid;
        }
        $where['account_userid'] = $userid;
        return $this->find($where);
    }

    /**
     * 检查用户现金余额是否足够
     *
     * @param  $amount
     * @return bool
     */
    public function isCash($amount)
    {
        $userInfo = $this->getUserCashInfo();
        $cash = $userInfo->account_cash;
        if (bccomp(floatval($amount), floatval($cash), 3) === 1) {
            return false;
        }
        return true;
    }

    /**
     * 查询用户余额
     *
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getCash()
    {
        $where['account_userid'] = $this->session->userid;
        $info = $this->find($where);
        if ($info == null) {
            return 0;
        }
        return $info->account_cash;
    }

    /**
     * 查询用户在途资金
     *
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getPending()
    {
        $where['account_userid'] = $this->session->userid;
        $info = $this->find($where);
        if ($info == null) {
            return 0;
        }
        return $info->account_pending;
    }

    /**
     * 增加用户现金余额
     *
     * @param  $orderNo 成交单号
     * @param  $type 类型
     * @param  $status 状态
     * @param  $in 收入
     * @param  $userid 用户id
     * @author zhoutao
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function revokeOrder($orderNo,$type,$status,$in,$userid)
    {
        $lockData = new LockData;
        $key = "userCash" . $userid;
        $lockData->lock($key);

        $date = date('Y-m-d H:i:s');
        $model = $this->modelclass;
        $where['account_userid'] = $userid;
        $info = $model::where($where)->first();
        $info->account_cash += $in;
        $info->account_change_time = $date;

        //判断在途为负则返回错误
        if ($info->account_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($info);

        $userCashAccountRes['accountPending'] = $info->account_pending;
        $userCashAccountRes['accountCash'] = $info->account_cash;

        //写入用户流水
        $userCashJournalData = new CashJournalData;
        $userCashJournalData->add('', $orderNo, $userCashAccountRes, 0, $type, $status, $in, 0, $userid, $date);
    
        $lockData->unlock($key);
        return $userCashAccountRes;
    }


    /**
     * 增加用户在途
     *
     * @param  $jobNo 关联单号
     * @param  $pending 在途增加金额
     * @param  $userid 用户id
     * @author zhoutao
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function increasePending($jobNo,$pending,$userid,$type,$status,$date = null)
    {
        $lockData = new LockData;
        $key = "userCash" . $userid;
        $lockData->lock($key);

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        
        $model = $this->modelclass;
        $where['account_userid'] = $userid;
        $info = $model::where($where)->first();
        $info->account_pending += $pending;
        $info->account_change_time = $date;

        //判断在途为负则返回错误
        if ($info->account_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }
        
        $this->save($info);

        $userCashAccountRes['accountPending'] = $info->account_pending;
        $userCashAccountRes['accountCash'] = $info->account_cash;

        //写入用户流水
        $userCashJournalData = new CashJournalData;
        $userCashJournalData->add('', $jobNo, $userCashAccountRes, $pending, $type, $status, 0, 0, $userid, $date);
        
        $lockData->unlock($key);
    }

    /**
     * 增加用户余额
     *
     * @param  $jobNo 关联单号
     * @param  $cash 增加的金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $userid 用户id
     * @author zhoutao
     * 
     * 修改了金额减少的bug
     * @author zhoutao
     * @date   2017.9.14
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function increaseCash($jobNo,$cash,$type,$status,$userid, $date = null)
    {
        $lockData = new LockData;
        $key = "userCash" . $userid;
        $lockData->lock($key);

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->modelclass;
        $where['account_userid'] = $userid;
        $info = $model::where($where)->first();
        $info->account_cash += $cash;
        $info->account_change_time = $date;

        //判断在途为负则返回错误
        if ($info->account_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($info);

        $userCashAccountRes['accountPending'] = $info->account_pending;
        $userCashAccountRes['accountCash'] = $info->account_cash;

        //写入用户流水
        $userCashJournalData = new CashJournalData;
        $userCashJournalData->add('', $jobNo, $userCashAccountRes, 0, $type, $status, $cash, 0, $userid, $date);
    
        $lockData->unlock($key);
    }

    /**
     * 减少用户在途
     *
     * @param  $jobNo 关联单号
     * @param  $pending 在途增加金额
     * @param  $userid 用户id
     * @author zhoutao
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function reducePending($jobNo,$pending,$userid,$type,$status,$date = null)
    {
        $lockData = new LockData;
        $key = "userCash" . $userid;
        $lockData->lock($key);

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        
        $model = $this->modelclass;
        $where['account_userid'] = $userid;
        $info = $model::where($where)->first();
        $info->account_pending -= $pending;
        $info->account_change_time = $date;

        //判断在途为负则返回错误
        if ($info->account_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($info);

        $userCashAccountRes['accountPending'] = $info->account_pending;
        $userCashAccountRes['accountCash'] = $info->account_cash;

        //写入用户流水
        $userCashJournalData = new CashJournalData;
        $userCashJournalData->add('', $jobNo, $userCashAccountRes, -$pending, $type, $status, 0, 0, $userid, $date);
        
        $lockData->unlock($key);
    }


    /**
     * 减少用户余额
     *
     * @param  $jobNo 关联单号
     * @param  $pending 在途增加金额
     * @param  $userid 用户id
     * @author zhoutao
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function reduceCash($jobNo,$cash,$userid,$type,$status)
    {
        $lockData = new LockData;
        $key = "userCash" . $userid;
        $lockData->lock($key);

        $date = date('Y-m-d H:i:s');
        $model = $this->modelclass;
        $where['account_userid'] = $userid;
        $info = $model::where($where)->first();
        $info->account_cash -= $cash;
        $info->account_change_time = $date;

        //判断在途为负则返回错误
        if ($info->account_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($info);

        $userCashAccountRes['accountPending'] = $info->account_pending;
        $userCashAccountRes['accountCash'] = $info->account_cash;

        //写入用户流水
        $userCashJournalData = new CashJournalData;
        $userCashJournalData->add('', $jobNo, $userCashAccountRes, 0, $type, $status, 0, $cash, $userid, $date);
        
        $lockData->unlock($key);
    }

    /**
     * 减少用户余额 增加在途
     *
     * @param  $jobNo 关联单号
     * @param  $pending 在途增加金额
     * @param  $userid 用户id
     * @author zhoutao
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function reduceCashIncreasePending($jobNo,$cash,$pending,$userid,$type,$status,$date = null)
    {
        $lockData = new LockData;
        $key = "userCash" . $userid;
        $lockData->lock($key);

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->modelclass;
        $where['account_userid'] = $userid;
        $info = $model::where($where)->first();
        $info->account_cash -= $cash;
        $info->account_pending += $pending;
        $info->account_change_time = $date;

        //判断在途为负则返回错误
        if ($info->account_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($info);

        $userCashAccountRes['accountPending'] = $info->account_pending;
        $userCashAccountRes['accountCash'] = $info->account_cash;

        //写入用户流水
        $userCashJournalData = new CashJournalData;
        $userCashJournalData->add('', $jobNo, $userCashAccountRes, $pending, $type, $status, 0, $cash, $userid, $date);
        
        $lockData->unlock($key);
    }

    /**
     * 增加金额 减少在途
     *
     * @param  $jobNo 关联单号
     * @param  $cash 增加的金额
     * @param  $pending 在途的金额
     * @param  $userid 用户id
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @author zhoutao
     * 
     * 增加了错误返回
     * @author zhoutao
     * @date   2017.10.10
     */
    public function increaseCashReducePending($jobNo,$cash,$pending,$userid,$type,$status,$date = null)
    {
        $lockData = new LockData;
        $key = "userCash" . $userid;
        $lockData->lock($key);

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        
        $model = $this->modelclass;
        $where['account_userid'] = $userid;
        $info = $model::where($where)->first();
        $info->account_cash += $cash;
        $info->account_pending -= $pending;
        $info->account_change_time = $date;

        //判断在途为负则返回错误
        if ($info->account_pending < 0) {
            $lockData->unlock($key);
            throw new Exception(self::ERROR_MSG);
        }

        $this->save($info);

        $userCashAccountRes['accountPending'] = $info->account_pending;
        $userCashAccountRes['accountCash'] = $info->account_cash;

        //写入用户流水
        $userCashJournalData = new CashJournalData;
        $userCashJournalData->add('', $jobNo, $userCashAccountRes, -$pending, $type, $status, $cash, 0, $userid, $date);

        $lockData->unlock($key);
        return $userCashAccountRes;
    }
    /**
     * 查询用户余额
     *
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getCashToday($userid)
    {
        $where['account_userid'] = $userid;
        $info = $this->find($where);
        if ($info == null) {
            return 0;
        }
        return $info->account_cash;
    }

    /**
     * 查询用户在途资金
     *
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getPendingToday($userid)
    {
        $where['account_userid'] = $userid;
        $info = $this->find($where);
        if ($info == null) {
            return 0;
        }
        return $info->account_pending;
    }

    public function getAccountToday()
    {
        $model=$this->newitem()->get();
        // $result=$model->get();
        return $model;
    }
}
