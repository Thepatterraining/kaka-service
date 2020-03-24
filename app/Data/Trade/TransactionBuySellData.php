<?php
namespace App\Data\Trade;

use App\Model\User\User;
use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;
use App\Http\Adapter\Trade\TranactionBuyAdapter;
use App\Http\Adapter\User\CashAccountAdapter;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Notify\INotifyDefault;
use App\Data\Utils\DocNoMaker;
use App\Data\Product\PreOrderData;
use App\Data\Sys\ErrorData;
use App\Data\Sys\LockData;

class TransactionBuySellData extends IDatafactory
{
    const LEVEL_TYPE_PRODUCT = 'BL01';
    const LEVEL_TYPE_MARKET = 'BL00';

    const LEVEL_TYPE_SELL_PRODUCT = 'SL01';
    const LEVEL_TYPE_SELL_MARKET = 'SL00';

    private $_leveToArray = [
        self::LEVEL_TYPE_SELL_PRODUCT => self::LEVEL_TYPE_PRODUCT,
        self::LEVEL_TYPE_SELL_MARKET => self::LEVEL_TYPE_MARKET,
    ];

    /**
     * 购买指定卖单
     *
     * @param  $sellNo 卖单号
     * @param  $count 数量
     * @param  $_voucherNo 现金券号
     * @param  $_preNo 预购单号
     * @author zhoutao
     * @date   2017.10.17
     * 
     * 增加买入所有小数
     * @author zhoutao
     * @date   2017.10.30
     * 
     * 去掉价格最低的限制
     * @author zhoutao
     * @date   2018.3.23 
     */
    public function buySell($sellNo, $count, $_voucherNo = '', $_preNo = '')
    {
        //查找卖单
        $lk = new LockData();
        $key = 'buySell' . $sellNo;
        $lk->lock($key);

        DB::beginTransaction();
        $sellData = new TranactionSellData();
        $sellRes = $sellData->getSellInfo($sellNo);
        $sellLevelType = $sellRes['levelType'];
        $sellCount = $sellRes['count'];
        $sellScale = $sellRes['scale'];
        $sellCount = bcdiv($sellCount, $sellScale, 9);

        //如果没传数量 就买入全部卖单数量
        if ($count == 0) {
            $count = $sellCount;
            //如果买入数量小于等于 0 或者 大于等于1 返回错误
            if ($count <= 0 || $count >= 1) {
                $lk->unlock($key);
                return ErrorData::SELL_COUNT_NOT_FLOUT;
            }
        }

        if ($sellLevelType == self::LEVEL_TYPE_SELL_MARKET && $sellCount < $count) {
            DB::rollBack();
            $lk->unlock($key);
            return ErrorData::$SELL_COUNT_NOT_ENOUGH;
        }
        
        //单价
        $price = $sellRes['toUserPrice'];
        //代币类型
        $coinType = $sellRes['coinType'];
        if (empty($coinType)) {
            DB::rollBack();
            $lk->unlock($key);
            return ErrorData::NOT_FOUND_NO;
        }

        if (empty($sellLevelType)) {
            DB::rollBack();
            $lk->unlock($key);
            return ErrorData::NOT_FOUND_NO;
        }

        //只有一级卖单才可以用券 如果是普通的把券设置为空
        if ($sellLevelType == self::LEVEL_TYPE_SELL_MARKET) {
            $_voucherNo = '';
            //判断是否价格最低
            // if ($sellData->isMinPrice($sellNo, $coinType) === false) {
            //     DB::rollBack();
            //     $lk->unlock($key);
            //     return ErrorData::NOT_FOUND_NO;
            // }
        }

        $docNo = new DocNoMaker();
        $transactionBuyNo = $docNo->Generate('TB');

        //买单级别
        $levelType = $this->sellLevelToBuyLevel($sellLevelType);

        
        $date = date('Y-m-d H:i:s');

        //执行挂买单业务
        $userCashBuyData = new UserCashBuyData();
        
        $userCashBuy = $userCashBuyData->addBuyOrder($transactionBuyNo, $count, $price, $coinType, $date, $_voucherNo, $levelType);
        if (is_int($userCashBuy)) {
            DB::rollBack();
            $lk->unlock($key);
            return $userCashBuy;
        }
        //调用成交查看是否有可成交
        $transactionOrderData = new TranactionOrderData();
        if ($sellLevelType == self::LEVEL_TYPE_SELL_MARKET) {
            $transactionOrderData->buyOrder($count, $price, $transactionBuyNo, $sellNo, $date);
        } else {
            $transactionOrderData->buyProduct($count, $price, $transactionBuyNo, $sellNo, $_voucherNo, $date);
        }
    
        if (!empty($_preNo)) {
            $preorderData = new PreOrderData;
            $preorderData->saveStatus($_preNo, PreOrderData::BOUGHT_STATUS);
            $preorderData->saveBuyNo($_preNo, $transactionBuyNo);
        }
        $res['count'] = $count;
        DB::commit();
        $lk->unlock($key);
        return $res;
    }


    /**
     * 把卖单级别转换成买单级别
     *
     * @param  $sellLevel 卖单级别
     * @author zhoutao
     * @date   2017.10.11
     */
    private function sellLevelToBuyLevel($sellLevel)
    {
        return $this->_leveToArray[$sellLevel];
    }

   
}
