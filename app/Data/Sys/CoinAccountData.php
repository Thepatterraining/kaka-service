<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Sys\CoinJournalData as SysCoinJournalData;

class CoinAccountData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;

    protected $no = 'account_type';

    protected $modelclass = 'App\Model\Sys\CoinAccount';

    /**
     * 增加系统代币
     *
     * @param   $coinType 代币类型
     * @param   $address 地址
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function addCoin($coinType, $address)
    {
        $model = $this->newitem();
        $model->account_type = $coinType;
        $model->account_address = $address;
        return $model->save();
    }

    /**
     * 查询系统代币
     *
     * @param   $coinType 代币类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getCoin($coinType)
    {
        $where['account_type'] = $coinType;
        return $this->find($where);
    }


    /**
     * 修改代币在途余额
     *
     * @param   $coinType 代币类型
     * @param   $amount 数量
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveCoin($coinType, $amount, $date)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getCoin($coinType);
        $amount = $model->account_pending + $amount;
        $cash = $model->account_cash;
        $id = $model->id;
        $model->account_pending = $amount;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $amount;
        $res['accountCash'] = $cash;
        $res['id'] = $id;
        return $res;
    }

    /**
     * 更新在途和余额
     *
     * @param   $coinType 代币类型
     * @param   $amount 数量
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePendingCash($coinType, $amount, $date)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getCoin($coinType);
        $pending = $model->account_pending - $amount;
        $cash = $model->account_cash + $amount;
        $model->account_pending = $pending;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $pending;
        $res['accountCash'] = $cash;
        return $res;
    }

    /**
     * 更新在途和余额
     *
     * @param   $coinType 代币类型
     * @param   $amount 数量
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function savePending($coinType, $amount, $date)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getCoin($coinType);
        $amount = $model->account_pending - $amount;
        $cash = $model->account_cash;
        $model->account_pending = $amount;
        $model->account_change_time = date('Y-m-d H:i:s');
        $res['res'] = $model->save();
        $res['accountPending'] = $amount;
        $res['accountCash'] = $cash;
        return $res;
    }

    /**
     * 余额增加，在途减少
     *
     * @param   $coinType 代币类型
     * @param   $pending 在途
     * @param   $cash 余额
     * @param   null                  $date 日期时间
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.30
     */
    public function saveCash($coinType, $pending, $cash, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getCoin($coinType);
        $amount = $model->account_pending - $pending;
        $cash = $model->account_cash + $cash;
        $model->account_pending = $amount;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $amount;
        $res['accountCash'] = $cash;
        return $res;
    }

    /**
     * 余额减少，在途增加
     *
     * @param   $coinType 代币类型
     * @param   $pending 在途
     * @param   $cash 余额
     * @param   null                  $date 日期时间
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.30
     */
    public function saveCashPending($coinType, $pending, $cash, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getCoin($coinType);
        $amount = $model->account_pending + $pending;
        $cash = $model->account_cash - $cash;
        $model->account_pending = $amount;
        $model->account_cash = $cash;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $amount;
        $res['accountCash'] = $cash;
        return $res;
    }


    /**
     *  平台余额减少
     *
     * @param $coinType 代币类型
     * @param $cash 减少的金额
     * @param $type 流水类型
     * @param $status 流水状态
     * @param $jobNo 关联单号
     * @param $date 时间
     */
    public function reduceCash($jobNo, $coinType, $cash, $type, $status, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getCoin($coinType);
        $model->account_cash -= $cash;
        $model->account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;
        

        //写入流水
        $journalData = new SysCoinJournalData;
        $journalData->addJournal('', 0, $jobNo, $res, $coinType, $type, $status, 0, $cash, $date);
    }

    /**
     *  平台在途增加
     *
     * @param  $jobNo 关联单号
     * @param  $coinType 代币类型
     * @param  $pending 在途
     * @param  $type 类型
     * @param  $status 状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.11.8
     */
    public function increasePending($jobNo, $coinType, $pending, $type, $status, $date)
    {
        $model = $this->getCoin($coinType);
        $model->account_pending += $pending;
        $model->account_change_time = $date;
        $model->save();
        
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;
        

        //写入流水
        $journalData = new SysCoinJournalData;
        $journalData->addJournal('', $pending, $jobNo, $res, $coinType, $type, $status, 0, 0, $date);
    }

    /**
     *  平台在途减少 余额增加
     *
     * @param  $jobNo 关联单号
     * @param  $coinType 代币类型
     * @param  $amount 数量
     * @param  $type 类型
     * @param  $status 状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.11.9
     */
    public function increaseCashReducePending($jobNo, $coinType, $amount, $type, $status, $date)
    {
        $model = $this->getCoin($coinType);
        $model->account_pending -= $amount;
        $model->account_cash += $amount;
        $model->account_change_time = $date;
        $model->save();
        
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;
        

        //写入流水
        $journalData = new SysCoinJournalData;
        $journalData->addJournal('', -$amount, $jobNo, $res, $coinType, $type, $status, $amount, 0, $date);
    }

    /**
     *  平台在途增加 余额减少
     *
     * @param  $jobNo 关联单号
     * @param  $coinType 代币类型
     * @param  $amount 数量
     * @param  $type 类型
     * @param  $status 状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.11.9
     */
    public function reduceCashIncreasePending($jobNo, $coinType, $amount, $type, $status, $date)
    {
        $model = $this->getCoin($coinType);
        $model->account_pending += $amount;
        $model->account_cash -= $amount;
        $model->account_change_time = $date;
        $model->save();
        
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;
        

        //写入流水
        $journalData = new SysCoinJournalData;
        $journalData->addJournal('', $amount, $jobNo, $res, $coinType, $type, $status, 0, $amount, $date);
    }

    /**
     *  平台在途减少
     *
     * @param  $jobNo 关联单号
     * @param  $coinType 代币类型
     * @param  $pending 在途
     * @param  $type 类型
     * @param  $status 状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.11.8
     */
    public function reducePending($jobNo, $coinType, $pending, $type, $status, $date)
    {
        $model = $this->getCoin($coinType);
        $model->account_pending -= $pending;
        $model->account_change_time = $date;
        $model->save();
        
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;
        

        //写入流水
        $journalData = new SysCoinJournalData;
        $journalData->addJournal('', -$pending, $jobNo, $res, $coinType, $type, $status, 0, 0, $date);
    }

    /**
     *  平台余额增加
     *
     * @param  $jobNo 关联单号
     * @param  $coinType 代币类型
     * @param  $pending 在途
     * @param  $type 类型
     * @param  $status 状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.11.8
     */
    public function increaseCash($jobNo, $coinType, $amount, $type, $status, $date)
    {
        $model = $this->getCoin($coinType);
        $model->account_cash += $amount;
        $model->account_change_time = $date;
        $model->save();
        
        $res['accountPending'] = $model->account_pending;
        $res['accountCash'] = $model->account_cash;
        

        //写入流水
        $journalData = new SysCoinJournalData;
        $journalData->addJournal('', 0, $jobNo, $res, $coinType, $type, $status, $amount, 0, $date);
    }


}
