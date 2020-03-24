<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Cash\JournalData;

class CashData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $modelclass = 'App\Model\Sys\Cash';

    /**
     * 增加现金账户在途金额
     *
     * @param   $amount
     * @return  mixed'
     * @author  zhoutao
     * @version 0.1
     */
    public function savePending($amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $res['pending'] = $model->sys_account_pending + $amount;
        $res['cash'] = $model->sys_account_cash;
        $model->sys_account_pending = $res['pending'];
        $model->sys_account_change_time = $date;
        $res['res'] = $model->save();
        return $res;
    }

     /**
      * 增加现金账户在途金额
      *
      * @param   $amount
      * @return  mixed'
      * @author  zhoutao
      * @version 0.1
      */
    public function savePendingReduce($amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        
        $model->sys_account_pending -= $amount;
        $model->sys_account_change_time = $date;

        $res['accountPending'] = $model->sys_account_pending;
        $res['accountCash'] = $model->sys_account_cash;
        $res['res'] = $model->save();
        return $res;
    }

    /**
     * 更新这个类型下的卡余额
     *
     * @param   $amount 在途金额
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     */
    public function saveTypePending($amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $pending = $model->sys_account_pending + $amount;
        $model->sys_account_pending = $pending;
        $model->sys_account_change_time = $date;
        $model->save();

        $res['accountPending'] = $pending;
        $res['accountCash'] = $model->sys_account_cash;
        return $res;
    }

    /**
     * 增加账户余额，减少在途
     *
     * @param   $amount  金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveCashPending($amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $res['pending'] = $model->sys_account_pending - $amount;
        $res['cash'] = $model->sys_account_cash + $amount;
        $model->sys_account_pending = $res['pending'];
        $model->sys_account_cash = $res['cash'];
        $model->sys_account_change_time = $date;
        $res['res'] = $model->save();
        return $res;
    }


    /**
     * 增加账户在途，减少余额
     *
     * @param   $amount  金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePendingCashTwo($amount, $cash, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $res['accountPending'] = $model->sys_account_pending + $amount;
        $res['accountCash'] = $model->sys_account_cash - $cash;
        $model->sys_account_pending = $res['accountPending'];
        $model->sys_account_cash = $res['accountCash'];
        $model->sys_account_change_time = $date;
        $res['res'] = $model->save();
        return $res;
    }

    /**
     * 增加账户余额，减少在途
     *
     * @param   $amount  金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveTypeCashPending($amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $pending = $model->sys_account_pending - $amount;
        $cash = $model->sys_account_cash + $amount;
        $model->sys_account_pending = $pending;
        $model->sys_account_cash = $cash;
        $model->sys_account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $pending;
        $res['accountCash'] = $cash;
        return $res;
    }

    /**
     * 减少在途金额
     *
     * @param   $amount 金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePendingShao($amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $res['pending'] = $model->sys_account_pending - $amount;
        $res['cash'] = $model->sys_account_cash;
        $model->sys_account_pending = $res['pending'];
        $model->sys_account_change_time = $date;
        $res['res'] = $model->save();
        return $res;
    }

    /**
     * 减少账户余额，减少在途
     *
     * @param   $amount  金额
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
        $res['accountPending'] = $model->sys_account_pending - $amount;
        $res['accountCash'] = $model->sys_account_cash - $amount;
        $model->sys_account_pending = $res['accountPending'];
        $model->sys_account_cash = $res['accountCash'];
        $model->sys_account_change_time = $date;
        $res['res'] = $model->save();
        return $res;
    }

    /**
     * 增加账户余额，在途不变
     *
     * @param   $amount  金额
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveCash($amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $res['pending'] = $model->sys_account_pending;
        $res['cash'] = $model->sys_account_cash + $amount;
        $model->sys_account_pending = $res['pending'];
        $model->sys_account_cash = $res['cash'];
        $model->sys_account_change_time = $date;
        $res['res'] = $model->save();
        return $res;
    }

    /**
     * 增加资金池在途
     *
     * @param  $jobNo 关联单号
     * @param  $sysBankid 银行卡号
     * @param  $pending 在途金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.8.21
     */
    public function increasePending($jobNo, $sysBankid, $pending, $type, $status, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $model->sys_account_pending += $pending;
        $model->sys_account_change_time = $date;
        $model->save();

        $cashAccount['accountPending'] = $model->sys_account_pending;
        $cashAccount['accountCash'] = $model->sys_account_cash;

        //写入流水
        $JournalData = new JournalData;
        $JournalData->add($jobNo, $sysBankid, $cashAccount, $pending, $type, $status, 0, 0, $date);

    }

    /**
     * 增加资金池在途 减少余额
     *
     * @param  $jobNo 关联单号
     * @param  $sysBankid 银行卡号
     * @param  $pending 在途金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.8.21
     */ 
    public function reduceCashIncreasePending($jobNo, $sysBankid, $pending, $cash, $type, $status, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $model->sys_account_pending += $pending;
        $model->sys_account_cash -= $cash;
        $model->sys_account_change_time = $date;
        $model->save();

        $cashAccount['accountPending'] = $model->sys_account_pending;
        $cashAccount['accountCash'] = $model->sys_account_cash;

        //写入流水
        $JournalData = new JournalData;
        $JournalData->add($jobNo, $sysBankid, $cashAccount, $pending, $type, $status, 0, $cash, $date);
    }

    /**
     * 减少资金池在途 增加余额
     *
     * @param  $jobNo 关联单号
     * @param  $sysBankid 银行卡号
     * @param  $pending 在途金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.8.21
     */ 
    public function reducePendingIncreaseCash($jobNo, $sysBankid, $pending, $cash, $type, $status, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $model->sys_account_pending -= $pending;
        $model->sys_account_cash += $cash;
        $model->sys_account_change_time = $date;
        $model->save();

        $cashAccount['accountPending'] = $model->sys_account_pending;
        $cashAccount['accountCash'] = $model->sys_account_cash;

        //写入流水
        $JournalData = new JournalData;
        $JournalData->add($jobNo, $sysBankid, $cashAccount, -$pending, $type, $status, $cash, 0, $date);
    }

    /**
     * 减少资金池在途
     *
     * @param  $jobNo 关联单号
     * @param  $sysBankid 银行卡号
     * @param  $pending 在途金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.8.21
     */
    public function reducePending($jobNo, $sysBankid, $pending, $type, $status, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->findForUpdate();
        $model->sys_account_pending -= $pending;
        $model->sys_account_change_time = $date;
        $model->save();

        $cashAccount['accountPending'] = $model->sys_account_pending;
        $cashAccount['accountCash'] = $model->sys_account_cash;

        //写入流水
        $JournalData = new JournalData;
        $JournalData->add($jobNo, $sysBankid, $cashAccount, -$pending, $type, $status, 0, 0, $date);

    }

    /**
     * 增加余额
     *
     * @param  $jobNo 关联单号
     * @param  $sysBankid 银行卡号
     * @param  $amount 金额
     * @param  $type 流水类型
     * @param  $status 流水状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.11.21
     */ 
    public function increaseCash($jobNo, $sysBankid, $amount, $type, $status, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->find();
        $model->sys_account_cash += $amount;
        $model->sys_account_change_time = $date;
        $model->save();

        $cashAccount['accountPending'] = $model->sys_account_pending;
        $cashAccount['accountCash'] = $model->sys_account_cash;

        //写入流水
        $JournalData = new JournalData;
        $JournalData->add($jobNo, $sysBankid, $cashAccount, 0, $type, $status, $amount, 0, $date);
    }

}
