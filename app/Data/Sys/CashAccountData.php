<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Sys\CashJournalData as SysCashJournalData;
use App\Data\User\UserTypeData;

class CashAccountData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\CashAccount';

    /**
     * 更新用户在途余额
     *
     * @param   $amount 要增加的金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePendingCash($amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $accountPending = $model->account_pending + $amount;
        $accountCash = $model->account_cash;
        $model->account_pending = $accountPending;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        return $res;
    }

    /**
     * 提现失败，在途平掉
     *
     * @param   $amount 提现手续费
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePending($amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $accountPending = $model->account_pending - $amount;
        $accountCash = $model->account_cash;
        $model->account_pending = $accountPending;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        return $res;
    }

    /**
     * 提现成功手续费到手
     *
     * @param   $amount 手续费
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePendingIn($amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $accountPending = $model->account_pending - $amount;
        $accountCash = $model->account_cash + $amount;
        $model->account_pending = $accountPending;
        $model->account_cash = $accountCash;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        return $res;
    }

    /**
     * 增加在途 减少现金
     *
     * @param   $cash 余额
     * @param   $amount 手续费
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveCashPendingTwo($amount, $cash, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $accountPending = $model->account_pending + $amount;
        $accountCash = $model->account_cash - $cash;
        $model->account_pending = $accountPending;
        $model->account_cash = $accountCash;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        return $res;
    }

    /**
     * 更新平台现金余额 cash-= pending-=
     *
     * @param   $amount
     * @param   $pending
     * @param   null    $date 日期
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveCash($amount, $pending, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $accountPending = $model->account_pending - $pending;
        $accountCash = $model->account_cash - $amount;
        $model->account_pending = $accountPending;
        $model->account_cash = $accountCash;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        return $res;
    }

    /**
     * 更新平台现金余额 cash+= pending-=
     *
     * @param   $amount
     * @param   $pending
     * @param   null    $date 日期
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveCashPending($amount, $pending, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $accountPending = $model->account_pending - $pending;
        $accountCash = $model->account_cash + $amount;
        $model->account_pending = $accountPending;
        $model->account_cash = $accountCash;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $accountPending;
        $res['accountCash'] = $accountCash;
        return $res;
    }

    /**
     * 减少平台余额
     *
     * @param $jobNo 关联单号
     * @param $cash 减少的金额
     * @param $type 流水类型
     * @param $status 流水状态
     * @param $date 时间
     */
    public function reduceCash($jobNo,$cash,$type,$status,$date = null)
    {
        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $sysBankid = $sysConfigs[UserTypeData::$SYS_FEE_ACCOUNT];

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $model->account_cash -= $cash;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;

        //写入流水
        $JournalData = new SysCashJournalData;
        $JournalData->add('', $jobNo, 0, $res, $type, $status, 0, $cash, $date, $sysBankid);

    }


    /**
     * 增加平台余额
     *
     * @param  $jobNo 关联单号
     * @param  $cash 增加的金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $date 时间
     * @author zhoutao
     */
    public function increaseCash($jobNo,$cash,$type,$status,$date = null)
    {
        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $sysBankid = $sysConfigs[UserTypeData::$SYS_FEE_ACCOUNT];

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $model->account_cash += $cash;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;

        //写入流水
        $JournalData = new SysCashJournalData;
        $JournalData->add('', $jobNo, 0, $res, $type, $status, $cash, 0, $date, $sysBankid);

    }

    /**
     * 增加平台在途
     *
     * @param  $jobNo 关联单号
     * @param  $cash 增加的金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $date 时间
     * @author zhoutao
     */
    public function increasePending($jobNo,$amount,$type,$status,$date = null)
    {
        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $sysBankid = $sysConfigs[UserTypeData::$SYS_FEE_ACCOUNT];

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->find();
        $model->account_pending += $amount;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;

        //写入流水
        $JournalData = new SysCashJournalData;
        $JournalData->add('', $jobNo, $amount, $res, $type, $status, 0, 0, $date, $sysBankid);

    }

    /**
     * 减少平台在途
     *
     * @param  $jobNo 关联单号
     * @param  $cash 增加的金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $date 时间
     * @author zhoutao
     */
    public function reducePending($jobNo, $amount, $type, $status, $date = null)
    {
        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $sysBankid = $sysConfigs[UserTypeData::$SYS_FEE_ACCOUNT];

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->find();
        $model->account_pending -= $amount;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;

        //写入流水
        $JournalData = new SysCashJournalData;
        $JournalData->add('', $jobNo, -$amount, $res, $type, $status, 0, 0, $date, $sysBankid);

    }

    /**
     * 增加平台在途
     *
     * @param  $jobNo 关联单号
     * @param  $cash 增加的金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.11.24
     */
    public function increaseCashReducePending($jobNo, $amount, $type, $status, $date = null)
    {
        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $sysBankid = $sysConfigs[UserTypeData::$SYS_FEE_ACCOUNT];

        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->find();
        $model->account_pending -= $amount;
        $model->account_cash += $amount;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;

        //写入流水
        $JournalData = new SysCashJournalData;
        $JournalData->add('', $jobNo, -$amount, $res, $type, $status, $amount, 0, $date, $sysBankid);

    }
}
