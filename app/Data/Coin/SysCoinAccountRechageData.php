<?php
namespace App\Data\Coin;

use App\Data\IDataFactory;
use App\Data\Sys\CoinAccountData;
use App\Data\Sys\CoinData;
use Illuminate\Support\Facades\DB;
use App\Data\Utils\DocNoMaker;
use App\Data\Sys\CoinJournalData as SysCoinJournalData;
use App\Data\Sys\LockData;

class SysCoinAccountRechageData extends IDatafactory
{
    /**
     * 给平台充值代币业务
     *
     * @param   $coinType 代币类型
     * @param   $amount 充值数量
     * @author  zhoutao
     * @version 0.1
     * @date    2017.11.9
     */
    public function recharge($coinType, $amount)
    {
        $lk = new LockData();
        $key = 'sysCoin' . $coinType;
        $lk->lock($key);

        $doc = new DocNoMaker();
        $no = $doc->Generate('OR');
        $date = date('Y-m-d H:i:s');

        //创建钱包地址
        $addressData = new AddressData();
        $address = $addressData->createSysAddress($coinType);

        //查询代币池里面有没有这个币种
        $sysCoin = new CoinData();
        $sysCoinInfo = $sysCoin->getCoin($coinType);
        if ($sysCoinInfo === null) {
            $sysCoin->addCoin($coinType, $address);
        }

        //查询系统里面有没有这个币种
        $sysCoinAccount = new CoinAccountData();
        $sysCoinInfo = $sysCoinAccount->getCoin($coinType);
        if ($sysCoinInfo === null) {
            $sysCoinAccount->addCoin($coinType, $address);
        }

        DB::beginTransaction();
        
        //代币充值表添加数据
        $coinRecharge = new RechageData();
        $coinRecharge->addRecharge($no, $coinType, $amount, 0, $address, RechageData::SYS_RECHARGE_TYPE, RechageData::APPLY_STATUS, $date);

        //代币池代币余额 在途增加 += 充值数量
        $sysCoinRes = $sysCoin->increasePending($no, $coinType, $amount, JournalData::RECHARGE_TYPE, JournalData::APPLY_STATUS, $date);

        //平台代币账户 在途增加 += 充值数量
        $sysCoinAccount->increasePending($no, $coinType, $amount, SysCoinJournalData::RECHARGE_TYPE, SysCoinJournalData::APPLY_STATUS, $date);

        DB::commit();
        $lk->unlock($key);

        return $no;
    }

    /**
     * 审核成功
     *
     * @param   $no 单据号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.11.9
     */
    public function rechargeTrue($no)
    {
        $lk = new LockData();
        $key = 'sysCoin' . $no;
        $lk->lock($key);

        $date = date('Y-m-d H:i:s');
        //查询代币充值表数据
        $coinRecharge = new RechageData();
        $coinRechargeInfo = $coinRecharge->getByNo($no);
        if (!empty($coinRechargeInfo)) {
            $coinType = $coinRechargeInfo->coin_recharge_cointype;
            $amount = $coinRechargeInfo->coin_recharge_amount;
            $status = $coinRechargeInfo->coin_recharge_status;
            
            if ($status == RechageData::APPLY_STATUS) {
                DB::beginTransaction();
                //系统代币余额 在途平掉 -= 充值数量 余额 += 充值数量
                $sysCoin = new CoinData();
                $sysCoinRes = $sysCoin->increaseCashReducePending($no, $coinType, $amount, JournalData::RECHARGE_TYPE, JournalData::SUCCESS_STATUS, $date);

                //平台代币账户 在途减少 -= 充值数量 余额增加 += 充值数量
                $sysCoinAccount = new CoinAccountData();
                $sysCoinAccount->increaseCashReducePending($no, $coinType, $amount, SysCoinJournalData::RECHARGE_TYPE, SysCoinJournalData::SUCCESS_STATUS, $date);

                //更新充值表
                $coinRecharge->saveRecharge($no, RechageData::SUCCESS_STATUS, 1, $date);

                DB::commit();
            }
            
        }

        $lk->unlock($key);
        return $no;
        
    }
}
