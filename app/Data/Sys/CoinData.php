<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Coin\JournalData;

class CoinData extends IDatafactory
{

    protected $no = 'syscoin_account_type';

    protected $modelclass = 'App\Model\Sys\Coin';

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
        $model->syscoin_account_type = $coinType;
        $model->syscoin_account_address = $address;
        return $model->save();
    }

    /**
     * 查询系统代币
     *
     * @param   $coinType 代币类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 去掉锁
     * @author  zhoutao
     * @date    2017.11.9
     */
    public function getCoin($coinType)
    {
        $where['syscoin_account_type'] = $coinType;
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
    public function saveCoin($coinType, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getCoin($coinType);
        $amount = $model->syscoin_account_pending + $amount;
        $cash = $model->syscoin_account_cash;
        $id = $model->id;
        $model->syscoin_account_pending = $amount;
        $model->syscoin_account_change_time = $date;
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
    public function savePendingCash($coinType, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getCoin($coinType);
        $pending = $model->syscoin_account_pending - $amount;
        // dump($pending);
        $cash = $model->syscoin_account_cash + $amount;
        //dump($cash);
        $id = $model->id;
        $model->syscoin_account_pending = $pending;
        $model->syscoin_account_cash = $cash;
        $model->syscoin_account_change_time = $date;
        //dump($model);
        $res['res'] = $model->save();
        $res['accountPending'] = $pending;
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
    public function savePending($coinType, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getCoin($coinType);
        $amount = $model->syscoin_account_pending - $amount;
        $cash = $model->syscoin_account_cash;
        $id = $model->id;
        $model->syscoin_account_pending = $amount;
        $model->syscoin_account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $amount;
        $res['accountCash'] = $cash;
        $res['id'] = $id;
        return $res;
    }

    public function saveCashPending($coinType, $amount, $date = null)
    {
        if ($date == null) {
            $date = date('Y-m-d H:i:s');
        }
        $model = $this->getCoin($coinType);
        $pending = $model->syscoin_account_pending - $amount;
        $cash = $model->syscoin_account_cash - $amount;
        $id = $model->id;
        $model->syscoin_account_pending = $pending;
        $model->syscoin_account_cash = $cash;
        $model->syscoin_account_change_time = $date;
        $res['res'] = $model->save();
        $res['accountPending'] = $pending;
        $res['accountCash'] = $cash;
        $res['id'] = $id;
        return $res;
    }

    /**
     *  代币池在途增加
     *
     * @param  $jobNo 关联单号
     * @param  $coinType 代币类型
     * @param  $pending 在途
     * @param  $type 类型
     * @param  $status 状态
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.11.9
     */
    public function increasePending($jobNo, $coinType, $pending, $type, $status, $date)
    {
        $model = $this->getByNo($coinType);
        $model->syscoin_account_pending += $pending;
        $model->syscoin_account_change_time = $date;
        $model->save();
        
        $res['id'] = $model->id;
        $res['accountPending'] = $model->syscoin_account_pending;
        $res['accountCash'] = $model->syscoin_account_cash;
        
        //写入流水
        $journalData = new JournalData;
        $journalData->addJournal('', $coinType, $pending, $jobNo, $res, $type, $status, 0, 0, $date);
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
        $model = $this->getByNo($coinType);
        $model->syscoin_account_pending -= $amount;
        $model->syscoin_account_cash += $amount;
        $model->syscoin_account_change_time = $date;
        $model->save();
        
        $res['id'] = $model->id;
        $res['accountPending'] = $model->syscoin_account_pending;
        $res['accountCash'] = $model->syscoin_account_cash;
        

        //写入流水
        $journalData = new JournalData;
        $journalData->addJournal('', $coinType, -$amount, $jobNo, $res, $type, $status, $amount, 0, $date);
    }
}
