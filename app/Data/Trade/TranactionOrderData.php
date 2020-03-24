<?php
namespace App\Data\Trade;

use App\Data\Activity\VoucherInfoData;
use App\Data\Activity\VoucherStorageData;
use App\Data\Coin\FrozenData;
use App\Data\User\CashOrderData;
use App\Data\User\OrderData;
use App\Model\User\User;
use App\Data\IDataFactory;
use App\Data\User\CashAccountData;
use App\Data\Sys\CashAccountData as SysCashAccountData;
use App\Data\User\CashJournalData;
use App\Data\Sys\CashJournalData as SysCashJournalData;
use App\Data\User\CoinAccountData;
use App\Data\Sys\CoinAccountData as SysCoinAccountData;
use App\Data\User\CoinJournalData;
use App\Data\Sys\CoinJournalData as SysCoinJournalData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use \Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Data\Product\InfoData as ProductInfoData;
use App\Data\Utils\Formater;
use App\Data\User\UserTypeData;
use App\Data\Item\ContractData;
use App\Data\TradeIndexFactory;
use App\Data\Rank\OrderList;
use App\Data\Notify\INotifyDefault;
use App\Data\Sys\LockData;
use App\Data\Sys\PayUserData;
use App\Data\Schedule\IMinuteSchedule;
use App\Data\Voucher\VoucherFactory;
use App\Data\Frozen\FrozenFactory;
use App\Data\TradeIndex\HourTradeIndexFactory;
use App\Data\Activity\RegVoucherData;
use App\Data\Project\ProjectGuidingPriceData;
use App\Data\Project\ProjectInfoData;

/**
 * 成交类
 *
 * @author zhoutao
 * @date   2017.9.1
 */ 
class TranactionOrderData extends IDatafactory //implements INotifyDefault
{
    protected $modelclass = 'App\Model\Trade\TranactionOrder';
    protected $no = 'order_no';

    const SELL_LEVEL_TYPE_TWO = 'SL00';
    public static $SELL_LEVEL_TYPE_ONE = 'SL01';

    const BUY_LEVEL_TYPE_MARKET = 'BL00';

    public static $USER_CASH_ORDER_BUY_TYPE = 'UCORDER01';
    public static $USER_CASH_ORDER_BUY_PRODUCT_TYPE = 'UCORDER07';
    public static $USER_CASH_ORDER_SELL_TYPE = 'UCORDER02';

    const BUY_STATUS_TRADABLE = [
        'TB00',
        'TB01',
    ];

    const SELL_STATUS_TRADABLE = [
        'TS00',
        'TS01',
    ];

    const COIN_ORDER_COUPONS = '未使用';

    //二级市场成交为true
    private $_market = false;

    // /**
    //  * 实现每分钟执行的接口
    //  * @author zhoutao
    //  * @date 2017.9.1
    //  * 
    //  */ 
    // public function minuterun()
    // {
    //     //循环所有的买单
    //     $date = date('Y-m-d H:i:s');
    //     $buyData = new TranactionBuyData();
    //     $buyModel = $buyData->newitem();
    //     $buyModel->whereIn('buy_status', TranactionOrderData::BUY_STATUS_TRADABLE)->chunk(100,function($buys){
    //         foreach ($buys as $buy) {
    //             $this->buySellOrder($buy->buy_no,$date);
    //         }
    //     });

    //     //循环所有的卖单
    //     $sellData = new TranactionSellData();
    //     $sellModel = $sellData->newitem();
    //     $sellModel->where($sellWhere)->whereIn('sell_status', TranactionOrderData::SELL_STATUS_TRADABLE)->chunk(100,function(){
    //         foreach ($sells as $sell) {
    //             $this->sellOrder($sell->sell_no, $date);
    //         }
    //     });
    // }

    /**
     * 挂买单去查询有没有可以成交的卖单
     *
     * @param  $buyNo 买单号
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.8.18
     * 
     * 加入为空判断
     * @author zhoutao
     * @date   2017.8.24
     * 
     * 增加了状态的判断
     * @author zhoutao
     * @date   2017.9.1
     * 
     * 加锁
     * @author zhoutao
     * @date   2017.9.1
     * 
     * 增加了二级市场判断
     * @author zhoutao
     * @date   2017.9.1
     * 
     * 将_market 设为true
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 去掉了不能自己和自己撮合
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 判断数量大于0
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 增加默认值
     * @author zhoutao
     * @date   2017.9.4
     */ 
    public function buySellOrder($buyNo, $date)
    {
        $buyData = new TranactionBuyData();
        $sellData = new TranactionSellData();
        $lk = new LockData();
        $buyKey = 'buy' . $buyNo;
        $lk->lock($buyKey);
            //获取买单参数
            $buy = $buyData->getByNo($buyNo);
        if (!empty($buy)) {
            $price = $buy->buy_touser_showprice;
            $count = $buy->buy_touser_showcount;
            $coinType = $buy->buy_cointype;
            $buyUserid = $buy->buy_userid;
            $buyStatus = $buy->buy_status;
            $buyLevelType = $buy->buy_leveltype;

            if (in_array($buyStatus, TranactionOrderData::BUY_STATUS_TRADABLE) && $buyLevelType == TranactionOrderData::BUY_LEVEL_TYPE_MARKET) {
                    
                $sellModel = $sellData->newitem();
                $sellWhere['sell_leveltype'] = TranactionOrderData::SELL_LEVEL_TYPE_TWO;
                $sellWhere['sell_cointype'] = $coinType;
                $sells = $sellModel->where($sellWhere)->whereIn('sell_status', ['TS00','TS01'])->where('sell_touser_showprice', '<=', $price)->orderBy('sell_touser_showprice', 'asc')->orderBy('created_at', 'desc')->get();

                if (!$sells->isEmpty()) {
                    $this->_market = true;
                    foreach ($sells as $sell) {
                        $sellNo = $sell->sell_no;
                        $sellKey = 'sell' . $sellNo;
                        $lk->lock($sellKey);
                        //获取卖单参数
                        $sellCount = $sell->sell_touser_showcount - ($sell->sell_transcount / 0.01);
                        $sellUserid = $sell->sell_userid;
                            

                        //更新买单剩余数量
                        $res = true;
                        $newBuy = $buyData->getByNo($buyNo);
                        $count = $newBuy->buy_touser_showcount - ($newBuy->buy_transcount / 0.01);
                        if ($count <= $sellCount) {
                            //买单全部成交
                            if ($count > 0) {
                                $res = $this->transOrder($count, $sell->sell_touser_showprice, $buyNo, $sellNo, $date);
                            }         
                        } else {
                            //买单部分成交，再次循环
                            if ($sellCount > 0) {
                                $res = $this->transOrder($sellCount, $sell->sell_touser_showprice, $buyNo, $sellNo, $date);
                            }
                        }
                            
                        if (!is_array($res)) {
                            $lk->unlock($sellKey);
                            $lk->unlock($buyKey);
                            return false;
                        }

                        //差价退回
                        $count = $count <= $sellCount ? $count : $sellCount;
                        $buyAmount = $price * $count - $sell->sell_touser_showprice * $count;
                        $this->orderEvent($buyAmount, $res, $sellUserid, $buyUserid, $date);
                            
                        //删除交易
                            
                        $orderList = new OrderList($coinType);
                        $orderList->AddOrder($price, $count);
                        if ($res['count'] == 0) {
                            $lk->unlock($sellKey);
                            $lk->unlock($buyKey);
                            return true;
                        }
                        $lk->unlock($sellKey);
                    }
                }
            }
                

                
        }
            $lk->unlock($buyKey);
            
        
    }

    /**
     * 挂卖单去查询有没有可以成交的买单
     *
     * @param  $sellNo 卖单号
     * @param  $date 时间
     * @author zhoutao
     * @date   2017.8.18
     * 
     * 加入为空判断
     * @author zhoutao
     * @date   2017.8.24
     * 
     * 成交价格取查出来的买单的价格
     * @author zhoutao
     * @date   2017.8.31
     * 
     * 增加了状态的判断
     * @author zhoutao
     * @date   2017.9.1
     * 
     * 修改退回金额
     * @author zhoutao
     * @date   2018.9.1
     * 
     * 加锁
     * @author zhoutao
     * @date   2017.9.1
     * 
     * 增加了二级市场判断
     * @author zhoutao
     * @date   2017.9.1
     * 
     * 将_market 设为true
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 去掉了不能自己和自己撮合
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 判断数量大于0
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 增加默认值
     * @author zhoutao
     * @date   2017.9.4
     */
    public function sellOrder($sellNo, $date)
    {
        $buyData = new TranactionBuyData();
        $sellData = new TranactionSellData();
        $lk = new LockData();
        $sellKey = 'sell' . $sellNo;
        $lk->lock($sellKey);
            //获取卖单参数
            $sell = $sellData->getByNo($sellNo);
        if (!empty($sell)) {
            $price = $sell->sell_touser_showprice;
            $count = $sell->sell_touser_showcount;
            $coinType = $sell->sell_cointype;
            $sellUserid = $sell->sell_userid;
            $sellStatus = $sell->sell_status;
            $sellLevelType = $sell->sell_leveltype;

            if (in_array($sellStatus, TranactionOrderData::SELL_STATUS_TRADABLE) && $sellLevelType == TranactionOrderData::SELL_LEVEL_TYPE_TWO) {
                $buyModel = $buyData->newitem();
                // $buyWhere['buy_limit'] = $price;
                $buyWhere['buy_leveltype'] = TranactionOrderData::BUY_LEVEL_TYPE_MARKET;
                $buyWhere['buy_cointype'] = $coinType;
                $buis = $buyModel->where($buyWhere)->whereIn('buy_status', ['TB00','TB01'])->where('buy_touser_showprice', '>=', $price)->orderBy('buy_touser_showprice', 'desc')->orderBy('created_at', 'desc')->get();
                if (!$buis->isEmpty()) {
                    $this->_market = true;
                    foreach ($buis as $buy) {
                            
                        $buyNo = $buy->buy_no;
                        $buyKey = 'buy' . $buyNo;
                        $lk->lock($buyKey);
                        //获取买单参数
                        $buyCount = $buy->buy_touser_showcount - ($buy->buy_transcount / 0.01);
                        $buyUserid = $buy->buy_userid;
                            

                        //更新卖单剩余数量
                        $res = true;
                        $newSell = $sellData->getByNo($sellNo);
                        $count = $newSell->sell_touser_showcount - ($newSell->sell_transcount / 0.01);
                        if ($count <= $buyCount) {
                            //卖单全部成交
                            if ($count > 0) {
                                $res = $this->transOrder($count, $buy->buy_touser_showprice, $buyNo, $sellNo, $date);
                            }
                        } else {
                            //卖单部分成交，再次循环
                            if ($buyCount > 0) {
                                $res = $this->transOrder($buyCount, $buy->buy_touser_showprice, $buyNo, $sellNo, $date);
                            }
                        }

                        if (!is_array($res)) {
                            $lk->unlock($buyKey);
                            $lk->unlock($sellKey);
                            return false;
                        }


                        $buyCashBalance = array_get($res, 'buyCashBalance', 0);
                        $this->event($res, $buyCashBalance, $buyUserid, $sellUserid, ContractData::LEVEL_TYPE_MARKET);

                        //删除交易
                        $orderList = new OrderList($coinType);
                        $orderList->AddOrder($price, $count);
                        if ($res['sellCount'] == 0) {
                            $lk->unlock($buyKey);
                            $lk->unlock($sellKey);
                            return true;
                        }
                        $lk->unlock($buyKey);
                    }
                }
            }
                
        }
            $lk->unlock($sellKey);
            
    }

    /**
     * 转让市场的 写入现金成交纪录 收益权合同 通知
     *
     * @param  $res 成交返回数据
     * @param  $buyAmount 买方差价
     * @param  $buyUserid 买方id
     * @param  $sellUserid 卖方id
     * @author zhoutao
     * @date   2017.8.18
     * 
     * 加入收益权协议级别为二级市场
     * @author zhoutao
     * @date   2017.8.24
     */ 
    protected function orderEvent($buyAmount, $res, $sellUserid, $buyUserid ,$date)
    {
        $tranactionOrderNo = array_get($res, 'orderNo', '');
        $buyCashBalance = array_get($res, 'buyCashBalance', 0);
        if ($buyAmount > 0) {
            $userCashAccountData = new CashAccountData;
            $userCashAccountRes = $userCashAccountData->increaseCashReducePending($tranactionOrderNo, $buyAmount, $buyAmount, $buyUserid, CashJournalData::BUY_ORDER_RETREAT_TYPE, CashJournalData::BUY_ORDER_RETREAT_STATUS, $date);
            $buyCashBalance = array_get($userCashAccountRes, 'accountCash', 0);
        }     
        
        $this->event($res, $buyCashBalance, $buyUserid, $sellUserid, ContractData::LEVEL_TYPE_MARKET);
                        
    }

    /**
     * 写入现金成交纪录 收益权合同 通知
     *
     * @param  $res 成交返回数据
     * @param  $buyCashBalance 买方余额
     * @param  $buyUserid 买方id
     * @param  $sellUserid 卖方id
     * @author zhoutao
     * @date   2017.8.18
     * 
     * @param  $levelType 收益权级别
     * @author zhoutao
     * @date   2017.8.24
     */ 
    protected function event($res, $buyCashBalance, $buyUserid, $sellUserid, $levelType)
    {
        //获取成交返回的参数
        $sellAmount = array_get($res, 'sellAmount', 0);
        $sellCashBalance = array_get($res, 'sellCashBalance', 0);
        $buyOrderCash = array_get($res, 'buyAmount', 0);
        $tranactionOrderNo = array_get($res, 'orderNo', '');

        //写入现金成交记录
        $userCashOrderData = new CashOrderData();
        //写入买方
        $cashOrderRes = $userCashOrderData->add($tranactionOrderNo, $buyOrderCash, self::$USER_CASH_ORDER_BUY_TYPE, $buyCashBalance, $buyUserid);

        //写入卖方
         $cashOrderRes = $userCashOrderData->add($tranactionOrderNo, $sellAmount, self::$USER_CASH_ORDER_SELL_TYPE, $sellCashBalance, $sellUserid);
                        
        //写入收益权合同
        $contractData = new ContractData;
        $contractData->add($tranactionOrderNo, $levelType);

        //通知卖方用户
        $this->AddEvent("Order_Check", $sellUserid, $tranactionOrderNo);

        //通知买方用户
        $this->AddEvent("Order_Buy", $buyUserid, $tranactionOrderNo);
    }

    /**
     * 写入代币交易记录
     *
     * @param  $res 成交返回数据
     * @param  $buyUserid 买方id
     * @param  $sellUserid 卖方id
     * @param  $price 单价
     * @param  $count 数量
     * @param  $disCountType 优惠类型
     * @param  $voucherNo 优惠券号 默认未使用
     * @author zhoutao
     * @date   2017.10.11
     */
    private function eventUserCoinOrder($res, $buyUserid, $sellUserid, $price, $count, $disCountType, $voucherNo = self::COIN_ORDER_COUPONS)
    {
        $tranactionOrderNo = array_get($res, 'orderNo', '');
        $buyNo = array_get($res, 'buyNo', '');
        $sellNo = array_get($res, 'sellNo', '');
        $coinType = array_get($res, 'coinType', '');
        $amount = $price * $count;

        //写入代币成交记录
        $userOrderData = new OrderData();
        $userOrderData->add($buyNo, $tranactionOrderNo, $coinType, $price, $count, $disCountType, $voucherNo, 0, $amount, OrderData::BUY_TYPE, $buyUserid);
        
        $userOrderData->add($sellNo, $tranactionOrderNo, $coinType, $price, $count, $disCountType, self::COIN_ORDER_COUPONS, 0, $amount, OrderData::SELL_TYPE, $sellUserid);
    }

    /**
     * 购买卖单
     *
     * @param   $count 数量
     * @param   $price 单价
     * @param   $buyNo 买单号
     * @param   $sellNo 卖单号
     * @param   $voucherNo 现金券号
     * @param   $date 日期时间
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.30
     * 
     * 增加用户代币账单
     * @author  zhoutao
     * @date    2017.11.17
     */
    public function buyOrder($count, $price, $buyNo, $sellNo, $date)
    {
        $res = $this->buyTransOrder($count, $price, $buyNo, $sellNo, $date);

        if (!is_array($res)) {
            return false;
        }

        $sellData = new TranactionSellData();
        $sell = $sellData->getByNo($sellNo);
        $sellUserid = $sell->sell_userid;
        $buyUserid = $this->session->userid;
        $sellLevelType = $sell->sell_leveltype;
        
        $buyCashBalance = array_get($res, 'buyCashBalance', 0);

        $this->event($res, $buyCashBalance, $buyUserid, $sellUserid, ContractData::LEVEL_TYPE_MARKET);

        //写入用户代币账单
        $this->eventUserCoinOrder($res, $buyUserid, $sellUserid, $price, $count, OrderData::COUPONS_DIS_TYPE);

        return $res['count'];
    }

    /**
     * 购买产品
     *
     * @param   $count 数量
     * @param   $price 单价
     * @param   $buyNo 买单号
     * @param   $sellNo 卖单号
     * @param   $voucherNo 现金券号
     * @param   $date 日期时间
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.30
     * 
     * 加入收益权协议级别为一级产品
     * @author  zhoutao
     * @date    2017.8.24
     * 
     * 加入了成交后如果买单有剩余，则再次成交下个卖单
     * @author  zhoutao
     * @date    2017.10.20
     * 
     * 增加写入代币成交
     * 修改用卷判断问题
     * @author  zhoutao
     * @date    2017.11.10
     */
    public function buyProduct($count, $price, $buyNo, $sellNo, $voucherNo, $date)
    {
        $res = $this->buyTransOrder($count, $price, $buyNo, $sellNo, $date);

        if (!is_array($res)) {
            return false;
        }

        $reqVoucherData = new RegVoucherData;
        $storageData = new VoucherStorageData();
        $orderNo = array_get($res, 'orderNo', '');
        $buyAmount = array_get($res, 'buyAmount', 0);
        $buyTransCount = array_get($res, 'count', 0);
        $sellTransCount = array_get($res, 'sellCount', 0);
        $buyScale = array_get($res, 'scale', 0.01);
        $productFreezetime = $this->session->productFreezettime;
        $voucherFreezetime = 0;
        if (!empty($voucherNo) && $voucherNo != 'null') {
            //取券的冻结期
            $storageInfo = $storageData->getStorageInfo($voucherNo);
            if ($storageInfo != null) {
                $voucherData = new VoucherInfoData();
                $voucherInfo = $voucherData->getByNo($storageInfo->vaucherstorage_voucherno);
                if ($voucherInfo != null) {
                    $voucherFreezetime = $voucherInfo->voucher_locktime;
                    if ($productFreezetime > $voucherFreezetime) {
                        $freezetime = $productFreezetime;
                    } else {
                        $freezetime = $voucherFreezetime;
                    }
                    $voucherFac = new VoucherFactory;
                    $orderVoucherData = $voucherFac->CreateVoucher($voucherInfo, $storageInfo);
                    $usingVoucher = $voucherFac->createVoucherModelUseing($voucherInfo);
                    if ($usingVoucher->CanUsingVoucherBuy($voucherNo, $buyAmount, $this->session->userid) === true) {
                        $voucherNo = $orderVoucherData->ApplyVoucheToOrder($orderNo, $date, $freezetime);
                    }
                    if (empty($voucherNo)) {
                        return false;
                    }
                }
            }
        }

        if (empty($voucherNo) || $voucherNo == 'null') {
            //冻结
            $frozenFac = new FrozenFactory;
            $orderFrozenData = $frozenFac->CreateFrozen(FrozenData::PRODUCT_TYPE);
            $productFreezetime = date('U') + $productFreezetime;
            $productFreezetime = date('Y-m-d H:i:s', $productFreezetime);
            $orderFrozen = $orderFrozenData->orderFrozen($orderNo, $date, $productFreezetime);
            if (empty($orderFrozen)) {
                return false;
            }
        }

        $sellData = new TranactionSellData();
        $sell = $sellData->getByNo($sellNo);
        $sellUserid = $sell->sell_userid;
        $buyUserid = $this->session->userid;
        $coinType = $sell->sell_cointype;
        
        $buyCashBalance = array_get($res, 'buyCashBalance', 0);
        
        $this->event($res, $buyCashBalance, $buyUserid, $sellUserid, ContractData::LEVEL_TYPE_PRODUCT);

        $this->eventUserCoinOrder($res, $buyUserid, $sellUserid, $price, $count, OrderData::COUPONS_DIS_TYPE, $voucherNo);
           
        if (bccomp($buyTransCount, $sellTransCount, 9) && $sellTransCount == 0) {
            //查找价格最低的卖单
            $sellFirst = $sellData->getLpFirst($coinType);
            if (!empty($sellFirst)) {
                $sellNo = $sellFirst->sell_no;
                // $count = $count - $sellCount;
                //查询可用的现金券
                $voucher = $reqVoucherData->getUserProductVoucher($buyTransCount, $sellNo);
                $storageNo = '';
                if (!empty($voucher)) {
                    $voucherNo = $voucher->vaucher_no;
                    $storage = $storageData->getStorage($voucher->vaucher_no);
                    if (!empty($storage)) {
                        $storageNo = $storage->vaucherstorage_no;
                    }
                }
                return $this->buyProduct(bcdiv($buyTransCount, $buyScale, 9), $price, $buyNo, $sellNo, $storageNo, $date);
            }
            
        }

        return $res['count'];
        
    }

    /**
     * 执行交易
     *
     * @param   $count 交易数量 份
     * @param   $price 单价 份
     * @param   $buyNo 买单号
     * @param   $sellNo 卖单号
     * @param   $date 日期时间
     * @param   $userCashOrderBuyType 成交纪录类型
     * @return  int
     * @author  zhoutao
     * @version 0.1
     * @date    2017.8.16
     * 
     * 增加了redis 锁
     * @author  zhoutao
     * @date    2017.8.23
     */
    protected function transOrder($count, $price, $buyNo, $sellNo, $date)
    {
        $lk = new LockData();
        $lk->lock("transOrder");
        DB::beginTransaction();
        $count = $this->buyTransOrder($count, $price, $buyNo, $sellNo, $date);

        if ($count === false) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        $lk->unlock("transOrder");
        return $count;
    }

    /**
     * 交易
     *
     * @param  $count 交易数量 份
     * @param  $price 交易价格 份
     * @param  $buyNo 买单号
     * @param  $sellNo 卖单号
     * @param  $date 时间
     * @param  $voucherNo 现金券号
     * @param  $freezetime 冻结时间 
     * @author zhoutao
     * @date   2017.8.18
     * 
     * 增加了成交总价和均价
     * @author zhoutao
     * @date   2017.8.22
     * 
     * 修改了代币计算精度
     * @author zhoutao
     * @date   2017.8.23
     * 
     * 增加了买单卖单的一级二级类型
     * @author zhoutao
     * @date   2017.8.24
     * 
     * 把插入成交数据放到最后
     * @author zhoutao
     * @date   2017.8.31
     * 
     * 把买单的判断使用了bc库
     * @author zhoutao
     * @date   2017.8.31
     * 
     * 修改了调用k线
     * @author zhoutao
     * @date   2017.8.31
     * 
     * 修改了买方手续费
     * @author zhoutao
     * @date   2017.9.1
     * 
     * 把卖单的判断使用了bc库
     * @author zhoutao
     * @date   2017.9.1
     * 
     * 删除了pow 和 ceil 的使用 因为使用之后数值过大使bc库判断出错
     * @author zhoutaof
     * @date   2017.9.2
     * 
     * 判断了二级市场使用最小手续费
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 修改了k线参数
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 修改了bc库使用的精度
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 增加项目名称
     * @author zhoutao
     * @date   2017.11.17
     */ 
    public function buyTransOrder($count, $price, $buyNo, $sellNo, $date, $voucherNo = null, $freezetime = null)
    {

        //取出银行卡
        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $sysBankid = $sysConfigs[UserTypeData::$SYS_FEE_ACCOUNT];
        $coinAccuracy = $sysConfigs[UserTypeData::$COIN_ACCURACY];
        $leastBuyMarketCashFee = $sysConfigs[UserTypeData::LEAST_MARKET_CASH_BUY_FEE];
        $leastSellMarketCashFee = $sysConfigs[UserTypeData::LEAST_MARKET_CASH_SELL_FEE];

        
        //查找买单信息
        $buyData = new TranactionBuyData();
        $buyModel = $buyData->newitem();
        $buyWhere['buy_no'] = $buyNo;
        $buy = $buyModel::where($buyWhere)->first();

        //查找卖单信息
        $sellData = new TranactionSellData();
        $sellModel = $sellData->newitem();
        $sellWhere['sell_no'] = $sellNo;
        $sell = $sellModel::where($sellWhere)->first();
        //查询买方现金账户id
        $cashAccountData = new CashAccountData();
        $cashAccountModel = $cashAccountData->newitem();
        $buyCashWhere['account_userid'] = $buy->buy_userid;
        $buyCash = $cashAccountModel::where($buyCashWhere)->first();
        //查询卖方现金账户id
        $sellCashWhere['account_userid'] = $sell->sell_userid;
        $sellCash = $cashAccountModel::where($sellCashWhere)->first();
        if ($buy->buy_cointype !== $sell->sell_cointype) {
            return false;
        }

        //查询买方因子，显示数量和价格
        $buyScale = $buy->buy_scale;
        $buyToUserFeePrice = $buy->buy_touser_feeprice;
        $buyToUserFeeCount = $buy->buy_touser_feecount;

        //价格和数量 加因子
        $count = $count * $buyScale;
        $price = $price / $buyScale;

        //判断成交数量为最小的
        $sellTransCount = bcsub($sell->sell_count, $sell->sell_transcount, 9);
        if ($count > $sellTransCount) {
            $count = $sellTransCount;
        }

        $buyTransCount = bcsub($buy->buy_count, $buy->buy_transcount, 9);

        if ($buyTransCount <= 0 || $sellTransCount <= 0) {
            return false;
        }
        $coinType = $buy->buy_cointype;
        $sellCashFeeType = $sell->sell_feetype;
        $sellCashFeeRate = $sell->sell_feerate;
        $sellCoinFeeRate = $sell->sell_coinfeerate;
        $sellCoinFeeType = $sell->sell_coinfeetype;
        $sellPrice = $sell->sell_limit;
        $sellCashPrice = $sell->sell_showcoinprice;
        $buyCoinFee = $count * $buy->buy_feerate;
        $sellCoinFee = $sell->sell_coinfee;
        $buyCashFeeType = $buy->buy_cashfeetype;
        $buyCashFeeRate = $buy->buy_cashfeerate;
        $buyCoinFeeType = $buy->buy_feetype;
        $buyCoinFeeRate = $buy->buy_feerate;
        $buyLevelType = $buy->buy_leveltype;
        $sellLevelType = $sell->sell_leveltype;
        

        $buyCashPrice = $buy->buy_showprice;
        $amount = Formater::ceil($buyCashPrice * $count);
        $sellAmount = Formater::ceil($price * $count);
        $buyCashAmount = Formater::ceil($price * $count);
        

        switch ($buyCashFeeType) {
        case 'FR00':
            $buyCashFee = 0;
            break;
        case 'FR01':
            $buyCashFee = $buyCashAmount * $buyCashFeeRate;
            //二级市场使用最小手续费
            if ($this->_market === true) {
                $buyCashFee = $buyCashFee < $leastBuyMarketCashFee ? $leastBuyMarketCashFee : $buyCashFee;
            }
            break;
        case 'FR02':
            $buyCashFee = $buyCashAmount * $buyCashFeeRate;
            //二级市场使用最小手续费
            if ($this->_market === true) {
                $buyCashFee = $buyCashFee < $leastBuyMarketCashFee ? $leastBuyMarketCashFee : $buyCashFee;
            }
            break;
        default:
            break;
        }
        $buyCashFee = Formater::ceil($buyCashFee);

        $sellCashAmount = $buyCashAmount - $buyCashFee;

        switch ($sellCashFeeType) {
        case 'FR00':
            $sellCashFee = 0;
            break;
        case 'FR01':
            $sellCashFee = $sellAmount * $sellCashFeeRate;
            //二级市场使用最小手续费
            if ($this->_market === true) {
                $sellCashFee = $sellCashFee < $leastSellMarketCashFee ? $leastSellMarketCashFee : $sellCashFee;
            }
            break;
        case 'FR02':
            $sellCashFee = $sellAmount * $sellCashFeeRate;
            //二级市场使用最小手续费
            if ($this->_market === true) {
                $sellCashFee = $sellCashFee < $leastSellMarketCashFee ? $leastSellMarketCashFee : $sellCashFee;
            }
            break;
        default:
            break;
        }
        $sellCashFee = Formater::ceil($sellCashFee);


        $sysCashFee = $buyCashFee + $sellCashFee;

        switch ($sellCoinFeeType) {
        case 'FR00':
            $sellCoinFee = 0;
            $sellCoinCount = $count;
            break;
        case 'FR01':
            $sellCoinFee = $count * $sellCoinFeeRate;
            $sellCoinCount = $count;
            break;
        case 'FR02':
            $sellCoinFee = $count * $sellCoinFeeRate;
            $sellCoinCount = $count + $sellCoinFee;
            break;
        default:
            break;
        }

        $buyCoinCount = $sellCoinCount - $sellCoinFee;

        $buyCoinFee = 0;

        $sysCoinFee = $buyCoinFee + $sellCoinFee;

        //生成单据号
        $docMd5 = new DocMD5Maker();
        $docNo = new DocNoMaker();
        $tranactionOrderNo = $docNo->Generate('TO');
        $userCoinJournalNo = '';
        $userCashJournalNo = '';
        $sysCashJournalNo = '';
        $sysCoinJournalNo = '';
        //插入成交表
        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->getByNo($coinType);

        $tranactionOrderData = new TranactionOrderData();
        $tranactionOrderModel = $tranactionOrderData->newitem();
        $tranactionOrderModel->order_no = $tranactionOrderNo;
        $tranactionOrderModel->order_count = $count;
        $tranactionOrderModel->order_price = $price;
        $tranactionOrderModel->order_cash_rate = $sellCashFeeRate;
        $tranactionOrderModel->order_coin_rate = $buyCoinFeeRate;
        $tranactionOrderModel->order_cash_fee = $sellCashFee;
        $tranactionOrderModel->order_coin_fee = $buyCoinFee;
        $tranactionOrderModel->order_buy_no = $buyNo;
        $tranactionOrderModel->order_sell_no = $sellNo;
        $tranactionOrderModel->order_sell_userid = $sell->sell_userid;
        $tranactionOrderModel->order_buy_userid = $buy->buy_userid;
        $tranactionOrderModel->order_sell_coinaccount = $sell->sell_usercointaccount;
        $tranactionOrderModel->order_sell_cashacount = $sellCash->id;
        $tranactionOrderModel->order_buy_coinaccount = $buy->buy_usercointaccount;
        $tranactionOrderModel->order_buy_cashaccount = $buyCash->id;
        $tranactionOrderModel->order_cash = $sellAmount - $sellCashFee;
        $tranactionOrderModel->order_coin = $buyCoinCount - $buyCoinFee;
        $tranactionOrderModel->order_amount = $sellAmount;
        $tranactionOrderModel->order_coin_type = $sell->sell_cointype;
        $tranactionOrderModel->order_cash_feetype = $sellCashFeeType;
        $tranactionOrderModel->order_coin_feetype = $sellCoinFeeType;
        $tranactionOrderModel->order_buycash_feetype = $buyCashFeeType;
        $tranactionOrderModel->order_buycoin_feetype = $buyCoinFeeType;
        $tranactionOrderModel->order_buycash_feerate = $buyCashFeeRate;
        $tranactionOrderModel->order_buycash_fee = $buyCashFee;
        $tranactionOrderModel->order_sellcoin_feerate = $sellCoinFeeRate;
        $tranactionOrderModel->order_sellcoin_fee = $sellCoinFee;
        $tranactionOrderModel->order_scale = $buyScale;
        $tranactionOrderModel->order_touser_showprice = $price * $buyScale;
        $tranactionOrderModel->order_touser_showcount = $buyScale == 0 ? $count : $count / $buyScale;
        $tranactionOrderModel->order_buy_leveltype = $buyLevelType;
        $tranactionOrderModel->order_sell_leveltype = $sellLevelType;
        $tranactionOrderModel->project_name = $projectInfo->project_name;
        
        //卖方用户代币余额表扣除金额  在途金额 = 在途金额 - $sellCoinCount 余额不变
        $userCoinAccountData = new CoinAccountData();
        $userCoinAccountRes = $userCoinAccountData->savePendingShao($sell->sell_cointype, $sellCoinCount, $sell->sell_userid, $date);
        if ($userCoinAccountRes['res'] === false) {
            
            return false;
        }
        
        if ($sell->sell_leveltype == 'SL01' && $userCoinAccountRes['pending'] == 0 && $userCoinAccountRes['cash'] == 0) {
            //一级市场的卖单 成交后卖方代币余额和在途都为0 成为普通
            $userCoinAccountData->savePrimary($sell->sell_cointype, $sell->sell_userid);
        }

        //卖方写入用户代币流水表 在途金额 = - $buyCoinCount
        $userCoinAccount['pending'] = $userCoinAccountRes['pending'] + $sellCoinFee;
        $userCoinAccount['cash'] = $userCoinAccountRes['cash'] + $sellCoinFee;
        $userCoinAccount['id'] = $userCoinAccountRes['id'];
        $userCoinJournalData = new CoinJournalData();
        $userCoinJournalRes = $userCoinJournalData->addCoinJournal($userCoinAccount, $sell->sell_cointype, $userCoinJournalNo, -$buyCoinCount, $tranactionOrderNo, 'CJT06', 'UOJ08', 0, $buyCoinCount, $sell->sell_userid, $date);
        if ($userCoinJournalRes === false) {
            
            return false;
        }

        //卖方写入用户代币流水表 在途金额 = -$sellCoinFee 支出金额 = $sellCoinFee
        $userCoinJournalRes = $userCoinJournalData->addCoinJournal($userCoinAccountRes, $sell->sell_cointype, $userCoinJournalNo, 0, $tranactionOrderNo, 'CJT06', 'UOJ06', 0, $sellCoinFee, $sell->sell_userid, $date);
        if ($userCoinJournalRes === false) {
            
            return false;
        }

        //卖方用户余额表增加金额  余额 = 余额 + $sellAmount - $sellCashFee
        $cashAccountData = new CashAccountData();
        $cashAccountRes = $cashAccountData->saveUserCashAccountTwo($sellAmount - $sellCashFee, $sell->sell_userid, $date);
        if ($cashAccountRes['res'] === false) {
            
            return false;
        }

        //卖方写入用户现金流水表  收入 = $sellAmount
        $cashAccountJournal['accountPending'] = $cashAccountRes['accountPending'];
        $cashAccountJournal['accountCash'] = $cashAccountRes['accountCash'] + $sellCashFee;
        $sellCashBalance = $cashAccountRes['accountCash'];
        $userCashJournalData = new CashJournalData();
        $userCashJournalRes = $userCashJournalData->add($userCashJournalNo, $tranactionOrderNo, $cashAccountJournal, 0, 'CJ04', 'CJT06', $sellAmount, 0, $sell->sell_userid, $date);
        if ($userCashJournalRes === false) {
            
            return false;
        }
        
        //卖方写入用户现金流水表   支出 = $sellCashFee
        $userCashJournalRes = $userCashJournalData->add($userCashJournalNo, $tranactionOrderNo, $cashAccountRes, 0, 'CJ06', 'CJT06', 0, $sellCashFee, $sell->sell_userid, $date);
        if ($userCashJournalRes === false) {
            
            return false;
        }
        
        //买方用户现金余额表扣除金额  在途金额 = 在途金额 - $buyCashAmount 余额不变
        $cashAccountRes = $cashAccountData->savePendingShao($buyCashAmount + $buyCashFee, $buy->buy_userid, $date);
        if ($cashAccountRes['res'] === false) {
            
            return false;
        }

        //买方写入用户现金流水表  在途金额 = - $buyCashAmount - $buyCashFee
        $cashAccountJournal['accountPending'] = $cashAccountRes['accountPending'] + $buyCashFee;
        $cashAccountJournal['accountCash'] = $cashAccountRes['accountCash'];
        $buyCashBalance = $cashAccountRes['accountCash'];

        $userCashJournalRes = $userCashJournalData->add($userCashJournalNo, $tranactionOrderNo, $cashAccountJournal, -$buyCashAmount, 'CJ03', 'CJT06', 0, $buyCashAmount, $buy->buy_userid, $date);
        if ($userCashJournalRes === false) {
            
            return false;
        }

        //买方写入用户现金流水表  在途金额 = - $buyCashFee
        $userCashJournalRes = $userCashJournalData->add($userCashJournalNo, $tranactionOrderNo, $cashAccountRes, -$buyCashFee, 'CJ06', 'CJT06', 0, $buyCashFee, $buy->buy_userid, $date);
        if ($userCashJournalRes === false) {
           
            return false;
        }
 
        //买方用户代币余额表扣除金额  余额 = $buyCoinCount - $buyCoinFee
        $userCoinAccountRes = $userCoinAccountData->saveCashPending($buy->buy_cointype, $buyCoinCount - $buyCoinFee, 0, $buy->buy_userid, $date);
        if ($userCoinAccountRes['res'] === false) {
            
            return false;
        }

        //买方写入用户代币流水表 收入 = $buyCoinCount
        $userCoinAccount['pending'] = $userCoinAccountRes['pending'];
        $userCoinAccount['cash'] = $userCoinAccountRes['cash'] + $buyCoinFee;
        $userCoinAccount['id'] = $userCoinAccountRes['id'];
        $userCoinJournalRes = $userCoinJournalData->addCoinJournal($userCoinAccount, $buy->buy_cointype, $userCoinJournalNo, 0, $tranactionOrderNo, 'CJT06', 'UOJ08', $buyCoinCount, 0, $buy->buy_userid, $date);
        if ($userCoinJournalRes === false) {
            
            return false;
        }

        //买方写入用户代币流水表  支出 = $buyCoinFee
        $userCoinJournalRes = $userCoinJournalData->addCoinJournal($userCoinAccountRes, $buy->buy_cointype, $userCoinJournalNo, 0, $tranactionOrderNo, 'CJT06', 'UOJ06', 0, $buyCoinFee, $buy->buy_userid, $date);
        if ($userCoinJournalRes === false) {
            
            return false;
        }

        //更新平台现金账户 余额 = 余额 + $sysCashFee
        $sysCashAccountData = new SysCashAccountData();
        $sysCashAccountRes = $sysCashAccountData->saveCashPending($sysCashFee, 0, $date);
        if ($sysCashAccountRes['res'] === false) {
            
            return false;
        }

        //写入平台现金流水表 收入 = $buyCashFee
        $sysCashAccountResCopy['accountPending'] = $sysCashAccountRes['accountPending'];
        $sysCashAccountResCopy['accountCash'] = $sysCashAccountRes['accountCash'] - $sellCashFee;
        $cashJournalData = new SysCashJournalData();
        $cashJournalRes = $cashJournalData->add($sysCashJournalNo, $tranactionOrderNo, 0, $sysCashAccountResCopy, 'SCJ03', 'CJT06', $buyCashFee, 0, $date, $sysBankid);
        if ($cashJournalRes === false) {
            
            return false;
        }

        //写入平台现金流水表 收入 = $sellCashFee
        $cashJournalData = new SysCashJournalData();
        $cashJournalRes = $cashJournalData->add($sysCashJournalNo, $tranactionOrderNo, 0, $sysCashAccountRes, 'SCJ03', 'CJT06', $sellCashFee, 0, $date, $sysBankid);
        if ($cashJournalRes === false) {
            
            return false;
        }

        //更新平台代币账户 余额 = 余额 + $sysCoinFee
        $sysCoinAccountData = new SysCoinAccountData();
        $sysCoinInfo = $sysCoinAccountData->getCoin($sell->sell_cointype);
        if ($sysCoinInfo == null) {
            //如果平台没有这个代币，添加
            $addCoinRes = $sysCoinAccountData->addCoin($sell->sell_cointype, 'null');
            if ($addCoinRes === false) {
                
                return false;
            }
        }

        $sysCoinAccountRes = $sysCoinAccountData->saveCash($sell->sell_cointype, 0, $sysCoinFee, $date);
        if ($sysCoinAccountRes['res'] === false) {
            
            return false;
        }

        

        //写入系统代币流水表 收入 = $buyCoinFee
        $sysCoinJournalData = new SysCoinJournalData();
        $sysCoinAccountResCopy['accountPending'] = $sysCoinAccountRes['accountPending'];
        $sysCoinAccountResCopy['accountCash'] = $sysCoinAccountRes['accountCash'] - $sellCoinFee;
        $sysCoinJournalRes = $sysCoinJournalData->addJournal($sysCoinJournalNo, 0, $tranactionOrderNo, $sysCoinAccountResCopy, $sell->sell_cointype, 'COJ02', 'OJT06', $buyCoinFee, 0, $date);
        if ($sysCoinJournalRes === false) {
            
            return false;
        }
        

        //写入系统代币流水表 收入 = $sellCoinFee
        $sysCoinJournalData = new SysCoinJournalData();
        $sysCoinJournalRes = $sysCoinJournalData->addJournal($sysCoinJournalNo, 0, $tranactionOrderNo, $sysCoinAccountRes, $sell->sell_cointype, 'COJ02', 'OJT06', $sellCoinFee, 0, $date);
        if ($sysCoinJournalRes === false) {
            
            return false;
        }
        
        // info('开始更新卖单买单表');

        //更新买单表
        $buyWhere['buy_no'] = $buyNo;
        $buy = $buyModel::where($buyWhere)->first();
        $buyStatus = 'TB02';
        if (bccomp(bcsub($buy->buy_count, $buy->buy_transcount, 6), $count, 6) === 1) {
            $buyStatus = 'TB01';
        }
        
        $buy->buy_transcount = $buy->buy_transcount + $count;
        
        $totalAmount = $price * $count;
        $buy->buy_totalammount += $totalAmount; //成交总价
        $buy->buy_transammount = $buy->buy_totalammount / $buy->buy_transcount; //成交均价

        $buy->buy_status = $buyStatus; 
        $buy->buy_lasttranstime = date('Y-m-d H:i:s');

        $buyCount = $buy->buy_count - $buy->buy_transcount;
        $buyRes = $buy->save();
        if ($buyRes === false) {
            
            return false;
        }
        //更新卖单表
        $sellWhere['sell_no'] = $sellNo;
        $sell = $sellModel::where($sellWhere)->first();
        $sellStatus = 'TS02';
        $scount = intval($sell->sell_count * pow(10, $coinAccuracy));
        $stcount = intval($sell->sell_transcount * pow(10, $coinAccuracy));
        
        if (bccomp(bcsub($sell->sell_count, $sell->sell_transcount, 6), $count, 6) === 1) {
            $sellStatus = 'TS01';
        }
        
        $sell->sell_transcount = $sell->sell_transcount + $count;

        $sell->sell_totalammount += $totalAmount; //成交总价

        $sell->sell_transammount = $sell->sell_totalammount / $sell->sell_transcount; //成交均价
        $sell->sell_status = $sellStatus;
        $sell->sell_lasttranstime = $date;
        
        $sellCount = $sell->sell_count - $sell->sell_transcount;
        $sellRes = $sell->save();
        if ($sellRes === false) {
            
            return false;
        }
        // info('开始现金券');
        
        $tranactionOrderModel->save();
        //开始现金券 返回现金券号
        // info($voucherNo);
        // if (!empty($voucherNo) && $voucherNo != 'null') {
        //     // info('使用现金券');
        //     $voucherRes = $this->voucher($buyCashWhere['account_userid'], $userCashJournalNo, $tranactionOrderNo, $sysCashJournalNo, $voucherNo, $amount, $sell->sell_cointype, $buyCoinCount, $date, $freezetime, $sysBankid);
        //     if ($voucherRes === false) {
                
        //         return false;
        //     }
        // } else {
        //     if ($sell->sell_leveltype == $this::$SELL_LEVEL_TYPE_ONE) {
        //         $locktime = date('U') + $freezetime;
        //         $locktime = date('Y-m-d H:i:s', $locktime);
        //         //一级市场，没用代金券， 还是要给你进行代币冻结
        //         // info('没有使用现金券开始冻结');
        //         $frozenRes = $this->Frozen($buyCashWhere['account_userid'], $tranactionOrderNo, $sell->sell_cointype, $buyCoinCount, $locktime, $date, 'FT02');
        //         if ($frozenRes === false) {
                    
        //             return false;
        //         }
        //     }
        // }

        //调用k线
        $tradeIndexFac = new TradeIndexFactory;
        $tradeIndexFac->addTrade($coinType, $price * $buyScale);

        $res['buyAmount'] = $buyCashAmount+$buyCashFee;
        $res['sellAmount'] = $sellAmount - $sellCashFee;
        $res['sellCashBalance'] = $sellCashBalance;
        $res['buyCashBalance'] = $buyCashBalance;
        $res['orderNo'] = $tranactionOrderNo;
        $res['count'] = $buyCount;
        $res['sellCount'] = $sellCount;
        $res['buyScale'] = $buyScale;
        $res['buyNo'] = $buyNo;
        $res['sellNo'] = $sellNo;
        $res['coinType'] = $sell->sell_cointype;
        return $res;
    }

    public function voucher($buyId, $userCashJournalNo, $tranactionOrderNo, $sysCashJournalNo, $voucherNo, $amount, $cointype, $count, $date, $freezetime, $sysBankid = '',$type = '')
    {
        if ($voucherNo == null) {
            return true;
        }
        
        //查询用户是否有这个券并且未使用
        // info('查询现金券');
        $storageData = new VoucherStorageData();
        $storageInfo = $storageData->getStorageInfo($voucherNo);
        if ($storageInfo == null) {
            
            return false;
        }
        
        $voucherData = new VoucherInfoData();
        $voucherInfo = $voucherData->getByNo($storageInfo->vaucherstorage_voucherno);
        if ($voucherInfo == null) {
            return true;
        }
        $val1 = $voucherInfo->voucher_val1;
        $val2 = $voucherInfo->voucher_val2;
        if (intval($val1) > intval($amount)) {
            return true;
        }

        // info('开始写入现金券流水');
        //买方用户余额 余额 += 现金券金额
        $cashAccountData = new CashAccountData();
        $cashAccountRes = $cashAccountData->saveUserCashAccountTwo($val2, $buyId, $date);
        if ($cashAccountRes['res'] === false) {
            
            return false;
        }
        
        //买方用户现金流水插入 收入 = 现金券金额
        $userCashJournalData = new CashJournalData();
        $userCashJournalRes = $userCashJournalData->add($userCashJournalNo, $tranactionOrderNo, $cashAccountRes, 0, 'CJ08', 'CJT06', $val2, 0, $buyId, $date);
        if ($userCashJournalRes === false) {
            
            return false;
        }

        //平台现金余额 余额 -= 现金券金额
        $sysCashAccountData = new SysCashAccountData();
        $sysCashRes = $sysCashAccountData->saveCash($val2, 0, $date);
        if ($sysCashRes['res'] === false) {
            
            return false;
        }

        //平台现金流水 支出 = 现金券金额
        $cashJournalData = new SysCashJournalData();
        $sysCashJournalRes = $cashJournalData->add($sysCashJournalNo, $tranactionOrderNo, 0, $sysCashRes, 'SCJ02', 'CJT06', 0, $val2, $date, $sysBankid);
        if ($sysCashJournalRes === false) {
            
            return false;
        }

        //更新用户现金券 变成已使用
        $storageRes = $storageData->saveVoucherStorageStatus('VOUS01', $voucherNo, $tranactionOrderNo, $date);
        if ($storageRes === false) {
            
            return false;
        }

        //更新该现金券使用数量 使用数量 += 1
        $voucherInfo->voucher_usecount = $voucherInfo->voucher_usecount + 1;
        $voucherInfoRes = $voucherInfo->save();
        if ($voucherInfoRes === false) {
            
            return false;
        }

        //更新买方用户代币账户锁定时间
        $locktime = empty($freezetime) ? $voucherInfo->voucher_locktime : $freezetime;
        $locktime = date('U') + $locktime;
        $locktime = date('Y-m-d H:i:s', $locktime);
        $userCoinAccountData = new CoinAccountData();
        $userCoinAccountModel = $userCoinAccountData->newitem();
        $userCoinAccountModel = $userCoinAccountModel::where('usercoin_account_userid', $buyId)->first();
        $userCoinAccountModel->usercoin_locktime = $locktime;
        $userCoinRes = $userCoinAccountModel->save();
        if ($userCoinRes === false) {
            
            return false;
        }

        if (empty($type)) {
             //使用现金券 进行代币冻结
            $frozenRes = $this->Frozen($buyId, $tranactionOrderNo, $cointype, $count, $locktime, $date, 'FT01');
            if ($frozenRes === false) {
                
                return false;
            }
        }
       

        //        //写入买方
        //        $userCashOrderData = new CashOrderData();
        //        $cashOrderRes = $userCashOrderData->add($tranactionOrderNo,$val2,'UCORDER07',$buyId);
        //        if ($cashOrderRes === false) {
        //            DB::rollBack();
        //            return false;
        //        }
        //
        //        //写入成交记录
        //        $userOrderData = new OrderData();
        //        $buyOrderRes = $userOrderData->add($buyNo,$tranactionOrderNo,$buyId,$price,$count,$disCountType,$voucherNo,0,$amount,'UORDER03',$buyId);
        //        if ($buyOrderRes === false) {
        //            DB::rollBack();
        //            return false;
        //        }

        return $storageInfo->vaucherstorage_voucherno;
    }

    protected function Frozen($userId, $jobNo, $coinType, $count, $locktime, $date, $frozenType)
    {
        //用户代币表 因为冻结，在途增加 += 冻结个数 余额 -= 冻结个数
        $accountData = new CoinAccountData();
        $accountRes = $accountData->savePendingCash($coinType, $count, $count, $userId, $date);
        if ($accountRes['res'] === false) {
            
            return false;
        }
        // Log::info($accountRes);

        //写入冻结表
        $data = new FrozenData();
        $frozenRes = $data->add($coinType, $accountRes['id'], $userId, $jobNo, $locktime, $frozenType, 'FS01');
        if ($frozenRes === false) {
            
            return false;
        }
        // Log::info($frozenRes);

        //查找冻结表的单据号
        $frozenInfo = $data->get($frozenRes);
        $frozenNo = $frozenInfo->frozen_no;

        //用户代币表发生变化 写入用户流水 支出 = 冻结个数 在途 = 冻结个数 关联 冻结单据号
        $journalData = new CoinJournalData();
        $journalNo = 'jskdjfkajkjfdkla'; //没有用的单据号，站位使用

        $journalRes = $journalData->addCoinJournal($accountRes, $coinType, $journalNo, $count, $frozenNo, 'CJT07', 'UOJ09', 0, $count, $userId, $date);
        if ($journalRes === false) {
            
            return false;
        }
        // Log::info($journalRes);

        return true;
    }


    /**
     * 卖单列表 查询一些信息
     *
     * @param   $coinType
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * 
     * 把成本价格改成项目指导价
     * @author  zhoutao
     * @date    2017.10.19
     * 
     * 修改项目指导价的获取
     * @author  zhoutao
     * @date    2017.10.20
     * 
     * 增加默认时间
     * @author  zhoutao
     * @date    2017.11.14
     */
    public function getInfo($coinType)
    {
        $model = $this->newitem();
        $where['order_coin_type'] = $coinType;
        $info = $model::where($where)->orderBy('created_at', 'desc')->first();
        if ($info == null) {
            $res['price'] = 0;
            $res['rose'] = 0;
            $res['date'] = '1970-01-01 00:00:00';
            return $res;
        }
        $item['price'] = $info->order_price;
        // $item['price'] = sprintf("%.2f",$item['price']);
        $item['date'] = $info->created_at->format('Y/m/d H:i:s');

        $one = date("Y-m-d", strtotime("-1 month"));

        $two = date('Y-m-d', strtotime("+1 day"));
        $whereBetween = [$one,$two];
        $oneInfo = $model::where($where)->whereBetween('created_at', $whereBetween)->orderBy('created_at', 'asc')->first();
        $twoInfo = $model::where($where)->whereBetween('created_at', $whereBetween)->orderBy('created_at', 'desc')->first();
        if (empty($oneinfo) || empty($twoInfo)) {
            $item['rose'] = 0;
            return $item;
        }
        $projectGuidingPriceData = new ProjectGuidingPriceData;
        $projectCostPrice = 0;
        $projectGuidingPrice = $projectGuidingPriceData->getGuidingPrice($twoInfo->order_coin_type);
        if (!empty($projectGuidingPrice)) {
            $projectCostPrice = $projectGuidingPrice->project_guidingprice;
        }
        if ($twoInfo->order_price == $oneInfo->order_price) {
            $item['rose'] = 0;
        } else {
            // $item['rose'] = ($twoInfo->order_price - $oneInfo->order_price) / $oneInfo->order_price * 100;
            
            $item['rose'] = $projectCostPrice == 0 ? 0 :($twoInfo->order_price * $twoInfo->order_scale - $projectCostPrice) / $projectCostPrice;
        }

        return $item;
    }

    /**
     * 成交量倒叙记录
     *
     * @param   $offset 从哪里开始
     * @param   $limit 从哪里结束
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.29
     */
    public function getHeat($offset, $limit)
    {
        $model = $this->newitem();
        $items = DB::select('select order_coin_type,sum(order_count) as sumcount from `transaction_order`  group by order_coin_type order by sumcount desc');
        //DB::table('transaction_order')
        //->select("select order_coin_type,count('transaction_order') from `transaction_order` where `transaction_order`.`deleted_at` is null  group by order_coin_type");

        //                    ->offset($offset)
        //                    ->limit($limit)
        //
        //  ->orderBy('order_count','desc')
        //   ->groupBy('order_coin_type','order_no')
        // ->get();
        return $items;
    }

    /**
     * 卖单时查询一些信息
     *
     * @param   $coinType 代币类型
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getSellInfo($coinType)
    {
        $model = $this->newitem();
        $where['order_coin_type'] = $coinType;
        $info = $model::where($where)->orderBy('created_at', 'desc')->first();
        if ($info == null) {
            $res['price'] = 0;
            $res['orderTotal'] = 0;
            $res['orderCount'] = 0;
            return $res;
        }
        $res['price'] = $info->order_price;
        $res['price'] = sprintf("%.2f", $res['price']);

        $one = date("Y-m-d", strtotime("-1 month"));
        $two = date('Y-m-d');
        $whereBetween = [$one,$two];
        $model = $model::whereBetween('created_at', $whereBetween);
        $res['orderTotal'] = $model->sum('order_amount');
        $res['orderTotal'] = sprintf("%.2f", $res['orderTotal']);
        $res['orderCount'] = $model->sum('order_count');
        return $res;
    }

    /**
     * 查询交易时间
     *
     * @param   $no 交易单据号
     * @return  date
     * @author  zhoutao
     * @version 0.1
     * @date    2017.3.27
     */
    public function getOrderDate($no)
    {
        $orderInfo = $this->getByNo($no);
        return $orderInfo->created_at->format('Y-m-d H:i:s');
    }

    /**
     * 查询首次成交时间
     *
     * @param   $coinType 代币类型
     * @return  date
     * @author  zhoutao
     * @version 0.1
     * @date    2017.9.4
     */
    public function getFirstOrderDate($coinType)
    {
        $model = $this->modelclass;
        $where['order_coin_type'] = $coinType;
        $info = $model::where($where)->orderBy('created_at', 'asc')->first();
        if (empty($info)) {
            return date('Y-m-d');
        }
        $date = $info->created_at->format('Y-m-d H:i:s');
        return date("Y-m-d", strtotime($date . "+90 day"));
    }

    /**
     * 查询成交价格的总和
     *
     * @author zhoutao
     */
    public function getOrderTotalSum()
    {
        $model = $this->newitem();
        $where['order_buy_userid'] = $this->session->userid;
        $total = $model->where($where)->sum('order_cash');
        return $total;
    }

    /**
     * 通过买方id查询成交价格的总和
     *
     * @author zhoutao
     */
    public function getOrderSumByBuyUserId($buyUserId)
    {
        $model = $this->newitem();
        $where['order_buy_userid'] = $buyUserId;
        $total = $model->where($where)->get();
        $result=0;
        foreach($total as $value)
        {
            $result=$result+floor($value->order_cash * 100)/100;
        }
        $result=floor($result * 100)/100;
        return $result;
    }

    /**
     * 通过买方id查询一段时间内成交价格总和
     *
     * @param  $buyUserId 购买用户id
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getOrderSumByBuyUserIdDaily($buyUserId,$start,$end)
    {
        $model = $this->newitem();
        $where['order_buy_userid'] = $buyUserId;
        $total = $model->where($where)->whereBetween('created_at', [$start,$end])->get();//->sum('order_cash');
        $result=0;
        foreach($total as $value){
            $result=$result + floor($value->order_cash * 100)/100;
        }
        $result=floor($result * 100)/100;
        return $result;
    }

    /**
     * 通过买方id查询一段时间内成交价格的集合
     *
     * @param  $buyUserId 购买用户id
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getOrderByBuyUserIdDaily($buyUserId,$start,$end)
    {
        $model = $this->newitem();
        $where['order_buy_userid'] = $buyUserId;
        $total = $model->where($where)->whereBetween('created_at', [$start,$end])->get();
        return $total;
    }

    /**
     * 通过买方id查询成交价格的集合
     *
     * @param  $buyUserId 购买用户id
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getOrderByBuyUserId($buyUserId)
    {
        $model = $this->newitem();
        $where['order_buy_userid'] = $buyUserId;
        $total = $model->where($where)->get();
        return $total;
    }

    /**
     * 通过卖方id查询一段时间内成交价格的集合
     *
     * @param  $buyUserId 购买用户id
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getOrderBySellUserIdDaily($sellUserId,$start,$end)
    {
        $model = $this->newitem();
        $where['order_sell_userid'] = $sellUserId;
        $total = $model->where($where)->whereBetween('created_at', [$start,$end])->get();
        return $total;
    }

    /**
     * 查询一段时间内用户最近成交情况
     *
     * @param  $buyUserId 购买用户id
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getUserCountDaily($buyUserId,$start,$end)
    {
        $model = $this->newitem();
        $total = $model->where('order_buy_userid', $buyUserId)
            ->whereBetween('created_at', [$start,$end])
            ->first();
        return $total;
    }

    /**
     * 查询一段时间内成交数量
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getTradeCountDaily($start,$end)
    {
        $model = $this->newitem();
        $total = $model->whereBetween('created_at', [$start,$end])
            ->count();
        return $total;
    }

    /**
     * 查询一段时间内成交总金额
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getCashCountDaily($start,$end)
    {
        $model = $this->newitem();
        $total = $model->whereBetween('created_at', [$start,$end])
            ->sum('order_amount');
        return $total;
    }

    /**
     * 查询一段时间内成交人次
     *
     * @param  $start 开始时间
     * @param  $end 结束时间
     * @author liu
     */
    public function getInvCountDaily($start,$end)
    {
        $model = $this->newitem();
        $total = DB::select('select count(distinct order_buy_userid) as count from transaction_order where created_at between ? and ?', [$start,$end]);
        return $total;
    }

    public function getTradeDaily($start,$end)
    {
        $model=$this->newitem();
        $result=$model->whereBetween('created_at', [$start,$end])->get();
        return $result;
    }

    public function getByOrderNo($no)
    {
        $model=$this->newitem();
        $result=$model->where('order_no', $no)->first();
        return $result;
    }

    // public function notifycreateddefaultrun($data)
    // {
        // $time=time();
        // if($time>=strtotime('2017-9-24 15:00:00') && $time<=strtotime('2017-10-5 0:00:00'))
        // {   
        //     $tranactionBuyData=new TranactionBuyData;
        //     $userTypeData = new UserTypeData;

        //     $buyNo=$data['order_buy_no'];
        //     $coinType=$data['order_coin_type'];
        //     $levelType=$tranactionBuyData->getLevelType($buyNo);  
        //     if($levelType=='BL01' && $coinType=="KKC-BJ0003")
        //     {
        //         $payUserData=new PayUserData;
        //         $infoData=new ProductInfoData;

        //         $userId=$data['order_buy_userid'];
        //         $this->session->userid=$userId;
        //         $amount=$data['order_count'];

        //         $sysConfigs = $userTypeData->getData($userId);

        //         $sysBankNo='152501671';

                
                
        //         if($amount>=0.99)
        //         {
        //             $product=$infoData->getProductByCoinType($coinType,2);
        //             if(!empty($product))
        //             {
        //                 $price=$product->product_price;
        //                 $feeType=$product->product_feetype;
        //                 $feeRate = $sysConfigs[UserTypeData::$CASH_BUY_FEE_RATE];
        //                 $productNo=$product->product_no;
                        
        //                 if($feeType=='FR00')
        //                 {
        //                     $fee=0;
        //                 }
        //                 else
        //                 {
        //                     $fee=$price * $feeRate * 2;
        //                 }
        //                 $count=$price *2 + $fee;
        //                 $no=$payUserData->createPay($sysBankNo,$userId,$count,"活动返现2份");
        //                 $payUserData->payTrue($no);
        //                 $infoData->buyProduct($productNo, 2, '');
        //             }
        //             else
        //             {
        //                 $count=$data['order_price'] * 0.02;
        //                 $no=$payUserData->createPay($sysBankNo,$userId,$count,"活动返现");
        //                 $payUserData->payTrue($no);
        //             }
        //         }   
        //         else if($amount>=0.66)
        //         {
        //             $product=$infoData->getProductByCoinType($coinType,1);
        //             if(!empty($product))
        //             {
        //                 $price=$product->product_price;
        //                 $feeType=$product->product_feetype;
        //                 $feeRate = $sysConfigs[UserTypeData::$CASH_BUY_FEE_RATE];
        //                 $productNo=$product->product_no;
        //                 if($feeType=='FR00')
        //                 {
        //                     $fee=0;
        //                 }
        //                 else
        //                 {
        //                     $fee=$price * $feeRate; 
        //                 }
        //                 $count=$price + $fee;
        //                 $no=$payUserData->createPay($sysBankNo,$userId,$count,"活动返现1份");
        //                 $payUserData->payTrue($no);
        //                 $infoData->buyProduct($productNo, 1, '');
        //             }
        //             else
        //             {
        //                 $count=$data['order_price'] * 0.01;
        //                 $no=$payUserData->createPay($sysBankNo,$userId,$count,"活动返现");
        //                 $payUserData->payTrue($no);
        //             }
        //         }
        //         else
        //         {
        //             return true;
        //         }
        //     }
        // }
    //     return true;
    // }

    // public function notifysaveddefaultrun($data)
    // {
          
    // }

    // public function notifydeleteddefaultrun($data)
    // {

    // }

    /**
     * 查询这个项目的最新成交价
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.8.23
     * 
     * 查询二级市场的
     * @author zhoutao
     * @date   2017.8.24
     */ 
    public function getOrderPrice($coinType)
    {
        $model = $this->modelclass;
        $where['order_coin_type'] = $coinType;
        $where['order_buy_leveltype'] = TranactionBuyData::LEVEL_TYPE_MARKET;
        $where['order_sell_leveltype'] = TranactionSellData::LEVEL_TYPE_MARKET;
        $info = $model::where($where)->orderBy('created_at', 'desc')->first();
        if (empty($info)) {
            return 0;
        }
        return bcmul($info->order_price, $info->order_scale, 2);
    }

    /**
     * 查询这个项目的月成交额
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.8.23
     * 
     * 查询二级市场的
     * @author zhoutao
     * @date   2017.8.24
     */ 
    public function getMonthAmount($coinType)
    {
        $model = $this->modelclass;
        $where['order_coin_type'] = $coinType;
        $where['order_buy_leveltype'] = TranactionBuyData::LEVEL_TYPE_MARKET;
        $where['order_sell_leveltype'] = TranactionSellData::LEVEL_TYPE_MARKET;
        $start = date('Y-m-d H:i:s', strtotime('-1 month'));
        $end = date('Y-m-d H:i:s');
        $amount = $model::where($where)->whereBetween('created_at', [$start,$end])->sum('order_amount');
        return Formater::ceil($amount);
    }

    /**
     * 查询这个项目的日成交额
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.9.13
     */
    public function getDayAmount($coinType)
    {
        $model = $this->modelclass;
        $where['order_coin_type'] = $coinType;
        $where['order_buy_leveltype'] = TranactionBuyData::LEVEL_TYPE_MARKET;
        $where['order_sell_leveltype'] = TranactionSellData::LEVEL_TYPE_MARKET;
        $start = date('Y-m-d H:i:s', strtotime('-1 day'));
        $end = date('Y-m-d H:i:s');
        $amount = $model::where($where)->whereBetween('created_at', [$start,$end])->sum('order_amount');
        return Formater::ceil($amount);
    }

    /**
     * 查询这个项目的日涨幅
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.9.13
     * 
     * 修改日涨幅计算规则为 （最新成交价 - 24小时前k线收盘价） ／ 24小时前k线收盘价 * 100
     * @author zhoutao
     * @date   2017.9.15
     */
    public function getDayRose($coinType)
    {
        $hourTradeIndexFac = new HourTradeIndexFactory;
        $hourTradeIndexModel = $hourTradeIndexFac->newitem();
        $start = date("Y-m-d H:i:s", strtotime("-1 day"));
        $end = date('Y-m-d H:i:s');
        //取这个时间的
        $startInfo = $hourTradeIndexModel->where('coin_type', $coinType)->where('time_open', '<=', $start)->where('time_close', '>=', $start)->first();
        if (empty($startInfo)) {
            //取之前的
            $startInfo = $hourTradeIndexModel->where('coin_type', $coinType)->where('time_close', '<=', $start)->orderBy('time_close', 'desc')->first();
            if (empty($startInfo)) {
                //取第一条
                $startInfo = $hourTradeIndexModel->where('coin_type', $coinType)->first();
            }
        }

        $model = $this->modelclass;
        $where['order_coin_type'] = $coinType;
        $where['order_buy_leveltype'] = TranactionBuyData::LEVEL_TYPE_MARKET;
        $where['order_sell_leveltype'] = TranactionSellData::LEVEL_TYPE_MARKET;

        $endInfo = $model::where($where)->orderBy('created_at', 'desc')->first();
        if (empty($startInfo) || empty($endInfo)) {
            return 0;
        }

        $startPrice = $startInfo->price_close;
        $endPrice = $endInfo->order_price;
        if ($startPrice == $endPrice) {
            $rose = 0;
        } else {
            $rose = bcdiv($endPrice - $startPrice, $startPrice, 5) * 100;
            $rose = sprintf("%.2f", $rose);
        }
        return Formater::ceil($rose);
    }

    /**
     * 查询这个项目的月涨幅
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.9.13
     * 
     * 把成本价格改成项目指导价
     * @author zhoutao
     * @date   2017.10.19
     * 
     * 修改项目指导价的获取
     * @author zhoutao
     * @date   2017.10.20
     */
    public function getMonthRose($coinType)
    {
        $model = $this->modelclass;
        $where['order_coin_type'] = $coinType;
        $where['order_buy_leveltype'] = TranactionBuyData::LEVEL_TYPE_MARKET;
        $where['order_sell_leveltype'] = TranactionSellData::LEVEL_TYPE_MARKET;
        $one = date("Y-m-d", strtotime("-1 month"));

        $two = date('Y-m-d', strtotime("+1 day"));
        $whereBetween = [$one,$two];
        $oneInfo = $model::where($where)->whereBetween('created_at', $whereBetween)->orderBy('created_at', 'asc')->first();
        $twoInfo = $model::where($where)->whereBetween('created_at', $whereBetween)->orderBy('created_at', 'desc')->first();
        if (empty($oneInfo) || empty($twoInfo)) {
            return 0;
        }
        
        $projectGuidingPriceData = new ProjectGuidingPriceData;
        $projectCostPrice = 0;
        $projectGuidingPrice = $projectGuidingPriceData->getGuidingPrice($twoInfo->order_coin_type);
        if (!empty($projectGuidingPrice)) {
            $projectCostPrice = $projectGuidingPrice->project_guidingprice;
        }
        
        if ($twoInfo->order_price == $oneInfo->order_price) {
            $rose = 0;
        } else {
            $rose = $projectCostPrice == 0 ? 0 : bcdiv($twoInfo->order_price * $twoInfo->order_scale - $projectCostPrice, $projectCostPrice, 2);
        }
        return $rose;
    }

    /**
     * 获取买单的总手续费
     *
     * @param  $no 买单号
     * @author zhoutao
     * @date   2017.9.1
     */ 
    public function getBuySumFee($no)
    {
        $model = $this->modelclass;

        $where['order_buy_no'] = $no;
        return  $model::where($where)->sum('order_buycash_fee');
        
    }

    /**
     * 获取卖单的总手续费
     *
     * @param  $no 买单号
     * @author zhoutao
     * @date   2017.9.1
     */ 
    public function getSellSumFee($no)
    {
        $model = $this->modelclass;

        $where['order_sell_no'] = $no;
        return  $model::where($where)->sum('order_cash_fee');
        
    }

    /**
     * 查询这个代币的历史最高成交价
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.18
     * 
     * 修改为order_price * order_scale
     * @author zhoutao
     * @date   2017.10.25
     */
    public function getHighestOrderPrice($coinType)
    {
        $model = $this->modelclass;
        $where['order_coin_type'] = $coinType;
        $info = $model::where($where)->orderBy('order_price', 'desc')->first();
        $highestOrderPrice = 0;
        if (!empty($info)) {
            $highestOrderPrice = $info->order_price * $info->order_scale;
        }
        return $highestOrderPrice;
    }

    /**
     * 查询成本记录
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date 2017.11.3
     * 
     * 增加了平均买入成本的计算
     * @author zhoutao
     * @date 2017.12.2
     */
    public function getBuyCosts($coinType)
    {
        $model = $this->modelclass;
        $where['order_coin_type'] = $coinType;
        $where['order_buy_userid'] = $this->session->userid;
        $orders = $model::where($where)->orderby('created_at', 'desc')->get();
        $buyCosts = [];
        $costs = 0;
        $sumCount = 0;
        foreach ($orders as $order) {
            $arr = [];
            $arr['count'] = bcdiv($order->order_count, $order->order_scale, 9);
            $arr['price'] = bcmul($order->order_price, $order->order_scale, 3);
            $arr['date'] = $order->created_at->format('Y-m-d H:i:s');
            $cost = bcmul($arr['count'], $arr['price']);
            $sumCount += $arr['count'];
            $costs += $cost;
            $buyCosts[] = $arr;
        }
        $res['avgCost'] = $sumCount == 0 ? 0 : $costs / $sumCount;
        $res['avgCost'] = Formater::floor($res['avgCost']);
        $res['costs'] = $buyCosts;
        $res['totalCost'] = $costs;
        return $res;
    }


}
