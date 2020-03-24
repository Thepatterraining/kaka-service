<?php
namespace App\Data\Trade;

use App\Model\User\User;
use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;
use App\Http\Adapter\Trade\TranactionBuyAdapter;
use App\Http\Adapter\User\CashAccountAdapter;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\Utils\Formater;
use App\Data\Sys\LockData;

class RevokeBuyData extends IDatafactory
{

    /**
     * 撤销买单操作
     *
     * @param   $transactionBuyNo 买单表单据号
     * @param   $date 时间
     * @author  zhoutao
     * @version 0.1
     * @date    2017.8.22
     * 
     * 增加了redis 锁
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function revokeBuy($transactionBuyNo, $date)
    {
        $lk = new LockData();
        $key = 'revokeBuy' . $transactionBuyNo;
        $lk->lock($key);

        DB::beginTransaction();
        $buyData = new TranactionBuyData;
        $buy = $buyData->getByNo($transactionBuyNo);
        $userid = $this->session->userid;
        
        if (empty($buy)) {
            DB::rollBack();
            $lk->unlock($key);
            return false;
        }

        if ($buy->buy_status == 'TB00' || $buy->buy_status == 'TB01') {
            //更新买单表
            $buyData = new TranactionBuyData();
            $buyRes = $buyData->saveBuy($transactionBuyNo);
            if ($buyRes['res'] === false) {
                DB::rollBack();
                $lk->unlock($key);
                return false;
            }
            $amount = $buyRes['amount'];
            
            $userCashBuyData = new UserCashBuyData;
            $buyFees = $userCashBuyData->getMarketFee($userid);
            $leastMarketCashFee = $buyFees['leastMarketCashFee'];

            $buyCashFeetype = $buyFees['buyCashFeetype'];
            $buyCashFeeRate = $buyFees['buyCashFeeRate'];
            $buyCashFee = 0;

            switch ($buyCashFeetype) {
            case UserCashBuyData::$SELL_FEE_TYPE_FREE:
                $buyCashFee = 0;
                break;
            case UserCashBuyData::$SELL_FEE_TYPE_IN:
                //价内
                $buyCashFee = $amount * $buyCashFeeRate;
                $buyCashFee = $buyCashFee < $leastMarketCashFee ? $leastMarketCashFee : $buyCashFee;
                break;
            case UserCashBuyData::$SELL_FEE_TYPE_OUT:
                //价外
                $buyCashFee = $amount * $buyCashFeeRate;
                $buyCashFee = $buyCashFee < $leastMarketCashFee ? $leastMarketCashFee : $buyCashFee;
                break;
            default:
                break;
            }
            //对手续费 保留 3位
            $buyCashFee = Formater::ceil($buyCashFee);
            $amount += $buyCashFee;

            //用户余额表增加金额  在途金额 = 在途金额 - （挂单数量 - 成交数量） * 单价 余额 = 余额 + （挂单数量 - 成交数量） * 单价

            $userCashAccountData = new CashAccountData();
            
            
            $userCashRes = $userCashAccountData->increaseCashReducePending($transactionBuyNo, $amount, $amount, $userid, CashJournalData::TRANSACTION_BUY_TYPE, CashJournalData::REVOKE_STATUS, $date);
        }
        DB::commit();
        $lk->unlock($key);
        return true;
        
    }
}
