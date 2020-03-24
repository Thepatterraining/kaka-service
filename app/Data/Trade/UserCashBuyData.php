<?php
namespace App\Data\Trade;

use App\Data\Activity\VoucherInfoData;
use App\Data\Activity\VoucherStorageData;
use App\Data\IDataFactory;
use App\Data\Project\ProjectInfoData;
use App\Data\User\CashAccountData;
use App\Data\User\CashJournalData;
use App\Data\User\CoinAccountData;
use App\Data\User\UserData;
use App\Data\User\UserTypeData;
use App\Http\Adapter\User\CashAccountAdapter;
use Illuminate\Support\Facades\DB;
use App\Data\Utils\Formater;
use App\Data\Sys\LockData;

class UserCashBuyData extends IDatafactory
{

    public static $SELL_FEE_TYPE_FREE = 'FR00';
    public static $SELL_FEE_TYPE_IN = 'FR01';
    public static $SELL_FEE_TYPE_OUT = 'FR02';

    public static $CASH_WITHDRAWAL_FEE_RATE = 'CASH_WITHDRAWALFEERATE';
    public static $CASH_BUY_FEE_RATE = 'CASH_BUYFEERATE';
    public static $CASH_SELL_FEE_RATE = 'CASH_SELLFEERATE';
    public static $CASH_BUY_FEE_HIDDEN = 'CASH_BUYFEEHIDDEN';
    public static $CASH_SELL_FEE_HIDDEN = 'CASH_SELLFEEHIDDEN';
    public static $COIN_WITHDRAWAL_FEE_RATE = 'COIN_WITHDRAWALFEERATE';
    public static $COIN_BUY_FEE_RATE = 'COIN_BUYFEERATE';
    public static $COIN_SELL_FEE_RATE = 'COIN_SELLFEERATE';
    public static $CASH_BUY_FEE_TYPE = 'CASH_BUYFEETYPE';
    public static $CASH_SELL_FEE_TYPE = 'CASH_SELLFEETYPE';
    public static $COIN_BUY_FEE_TYPE = 'COIN_BUYFEETYPE';
    public static $COIN_SELL_FEE_TYPE = 'COIN_SELLFEETYPE';
    public static $COIN_SELL_FEE_HIDDEN = 'COIN_SELLFEEHIDDEN';
    public static $COIN_BUY_FEE_HIDDEN = 'COIN_BUYFEEHIDDEN';
    public static $SHOW_COIN_SCALE = 'SHOW_COIN_SCALE';

    //存储一级 or 二级的方法
    private $_getFeeFunc;

    const GET_FEE = 'getFee';
    const GET_MARKET_FEE = 'getMarketFee';

    /**
     * 初始化决定使用一级 or 二级手续费
     *
     * @param  $getCashFee 获取一级 or 二级的方法 默认一级
     * @author zhoutao
     * @date   2017.9.4
     */ 
    public function __construct($getCashFee = UserCashBuyData::GET_FEE)
    {   
        parent::__construct();
        $this->_getFeeFunc = $getCashFee;
    }

    /**
     * 用户挂买单业务
     *
     * @param   $userCashJournalNo 用户现金流水单据号
     * @param   $transactionBuyNo 买单单据号
     * @param   $count 买单数量
     * @param   $price 买单单价
     * @param   $coin 买的币类型
     * @param   $date 创建日期
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     * 
     * 地区设为空
     * @author  zhoutao
     * @date    2017.10.19
     */
    public function TradeBuy($userCashJournalNo, $transactionBuyNo, $count, $price, $coin, $date)
    {
        $amount = $count * $price;

        DB::beginTransaction();
        $userCoinAccountData = new CoinAccountData();

        //如果没有这个代币账户，进行增加
        $userCoinAccountInfo = $userCoinAccountData->getUserCoin($coin, $this->session->userid);
        if ($userCoinAccountInfo == null) {
            $userCoinAccountId = $userCoinAccountData->addUserCoin($coin, $this->session->userid, false);
            if ($userCoinAccountId == null) {
                DB::rollBack();
                return false;
            }
            $userCoinAccountInfo = $userCoinAccountData->getUserCoin($coin);
        }

        //判断是否为一级市场
        $userCoinRes = $userCoinAccountData->isPrimary($coin);
        if ($userCoinRes === false) {
            DB::rollBack();
            return 806002;
        }

        //用户余额表扣除金额
        $userCashAccountData = new CashAccountData();
        //判断现金是否足够挂单
        $userCashAccountRes = $userCashAccountData->isCash($amount);
        if ($userCashAccountRes === false) {
            DB::rollBack();
            return 806001;
        }
        //在途金额 = 在途金额 + 买单金额 余额 = 余额 - 买单金额
        $userCashAccountRes = $userCashAccountData->saveUserPendingAccount($amount);
        if ($userCashAccountRes['res'] === false) {
            DB::rollBack();
            return false;
        }
        //写入用户流水表  在途 = + 买单金额  支出 = 买单金额
        $userCashJournalData = new CashJournalData();
        $userCashJournalRes = $userCashJournalData->add($userCashJournalNo, $transactionBuyNo, $userCashAccountRes, $amount, 'CJ03', 'CJT01', 0, $amount, $this->session->userid, $date);
        if ($userCashJournalRes === false) {
            DB::rollBack();
            return false;
        }
        //查询房产信息
        $region = '';

        //写入挂买单表
        $transactionBuyData = new TranactionBuyData();
        $transactionBuyRes = $transactionBuyData->addBuy($count, $price, $coin, $transactionBuyNo, $userCoinAccountInfo->id, $region);
        if ($transactionBuyRes === false) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }

    /**
     * 获取一级买方手续费信息
     *
     * @param  $userid 用户id
     * @author zhoutao
     * @date   2017.9.4
     */ 
    public function getFee($userid)
    {
        //获取系统配置信息
        $userTypeData = new UserTypeData();

        $sysConfigKey = $userTypeData->getData($userid);

        $res['buyCashFeetype'] = $sysConfigKey[UserTypeData::$CASH_BUY_FEE_TYPE];
        $res['buyCashFeeRate'] = $sysConfigKey[UserTypeData::$CASH_BUY_FEE_RATE];
        $res['buyCoinFeeType'] = $sysConfigKey[UserTypeData::$COIN_BUY_FEE_TYPE];
        $res['buyCoinFeeRate'] = $sysConfigKey[UserTypeData::$COIN_BUY_FEE_RATE];
        $res['leastMarketCashFee'] = 0;
        return $res;
    }

    /**
     * 获取二级买方手续费信息
     *
     * @param  $userid 用户id
     * @author zhoutao
     * @date   2017.9.4
     */ 
    public function getMarketFee($userid)
    {
        //获取系统配置信息
        $userTypeData = new UserTypeData();

        $sysConfigKey = $userTypeData->getData($userid);

        $res['buyCashFeetype'] = $sysConfigKey[UserTypeData::MARKET_CASH_BUY_FEE_TYPE];
        $res['buyCashFeeRate'] = $sysConfigKey[UserTypeData::MARKET_CASH_BUY_FEE_RATE];
        $res['buyCoinFeeType'] = $sysConfigKey[UserTypeData::MARKET_COIN_BUY_FEE_TYPE];
        $res['buyCoinFeeRate'] = $sysConfigKey[UserTypeData::MARKET_COIN_BUY_FEE_RATE];
        $res['leastMarketCashFee'] = $sysConfigKey[UserTypeData::LEAST_MARKET_CASH_BUY_FEE];
        return $res;
    }

    /**
     * 挂买单
     *
     * @param  $transactionBuyNo 买单号
     * @param  $count 数量
     * @param  $price 价格
     * @param  $coinType 代币类型
     * @param  $date 时间
     * @param  $_voucherNo 现金券号
     * @param  $levelType 买单级别
     * @author zhoutao
     * @date   2017.8.24
     * 
     * 删除了一个变量
     * @author zhoutao
     * @date   2017.8.24
     * 
     * 区分了一级 二级的手续费 增加了最小手续费
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 加入了事务和redis锁
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 修改比例因子和地区
     * @author zhoutao
     * @date   2017.10.19
     */ 
    public function addBuyOrder($transactionBuyNo, $count, $price, $coinType, $date, $_voucherNo, $levelType)
    {
        DB::beginTransaction();
        $lk = new LockData();
        $buyKey = 'createBuy';
        $lk->lock($buyKey);
        
        $storageData = new VoucherStorageData();

        $amount = Formater::ceil($count * $price);


        $userCoinAccountData = new CoinAccountData();

        //如果没有这个代币账户，进行增加
        $userCoinAccountInfo = $userCoinAccountData->getUserCoin($coinType, $this->session->userid);
        if ($userCoinAccountInfo == null) {
            $userCoinAccountId = $userCoinAccountData->addUserCoin($coinType, $this->session->userid, false);
            if ($userCoinAccountId == null) {
                $lk->unlock($buyKey);
                DB::rollBack();
                return false;
            }
            $userCoinAccountInfo = $userCoinAccountData->getUserCoin($coinType);
        }

        //判断是否为一级市场
        $userCoinRes = $userCoinAccountData->isPrimary($coinType);
        if ($userCoinRes === false) {
            $lk->unlock($buyKey);
            DB::rollBack();
            return 806002;
        }

        //查询用户类型
        $userid = $this->session->userid;
        $userData = new UserData();
        $userInfo = $userData->get($userid);
        $userType = $userInfo->user_type;

        //获取系统配置信息
        $userTypeData = new UserTypeData();

        $sysConfigKey = $userTypeData->getData($userid);

        //取出比例因子
        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->getByNo($coinType);
        $showCoinScale = $projectInfo->project_scale;

        //显示价格 = 输入价格 显示数量 = 输入数量
        $toUserShowPrice = $price;
        $toUserShowCount = $count;

        //价格 = 显示价格 ／ 比例因子 数量 = 显示数量 * 比例因子
        $price = $toUserShowPrice / $showCoinScale;
        $count = $toUserShowCount * $showCoinScale;

        $getFeeFunc = $this->_getFeeFunc;
        $buyFees = $this->$getFeeFunc($userid);
        $leastMarketCashFee = $buyFees['leastMarketCashFee'];

        $buyCashFeetype = $buyFees['buyCashFeetype'];//$sysConfigKey[UserTypeData::$CASH_BUY_FEE_TYPE];
        $buyCashFeeRate = $buyFees['buyCashFeeRate'];//$sysConfigKey[UserTypeData::$CASH_BUY_FEE_RATE];
        $buyCashFee = 0;
        $showBuyPrice = 0;

        switch ($buyCashFeetype) {
        case $this::$SELL_FEE_TYPE_FREE:
            $buyCashFee = 0;
            $showBuyPrice = $price;
            break;
        case $this::$SELL_FEE_TYPE_IN:
            //价内
            $buyCashFee = $amount * $buyCashFeeRate;
            $buyCashFee = $buyCashFee < $leastMarketCashFee ? $leastMarketCashFee : $buyCashFee;

            $showBuyPrice = $price / (1 + $buyCashFeeRate);
            break;
        case $this::$SELL_FEE_TYPE_OUT:
            //价外
            $buyCashFee = $amount * $buyCashFeeRate;
            $buyCashFee = $buyCashFee < $leastMarketCashFee ? $leastMarketCashFee : $buyCashFee;
            $showBuyPrice = $price * (1 + $buyCashFeeRate);
            break;
        default:
            break;
        }
        //对手续费 保留 3位
        $buyCashFee = Formater::ceil($buyCashFee);


        $buyCoinFeeType = $buyFees['buyCoinFeeType'];//sysConfigKey[UserTypeData::$COIN_BUY_FEE_TYPE];
        $buyCoinFeeRate = $buyFees['buyCoinFeeRate'];//$sysConfigKey[UserTypeData::$COIN_BUY_FEE_RATE];
        switch ($buyCoinFeeType) {
        case $this::$SELL_FEE_TYPE_FREE:
            $showBuyCount = $count;
            break;
        case $this::$SELL_FEE_TYPE_IN:
            //价内
            $showBuyCount = $count / (1 + $buyCoinFeeRate);
            break;
        case $this::$SELL_FEE_TYPE_OUT:
            //价外
            $showBuyCount = $count * (1 + $buyCoinFeeRate);
            break;
        default:
            break;
        }

        //给带手续费的显示价格和数量赋值
        $feePrice = $showBuyPrice * $showCoinScale;
        $feeCount = $showBuyCount / $showCoinScale;

        if (!empty($_voucherNo) || $_voucherNo != 'null') {
            //取券的
            $voucherCash = $storageData->getVoucherReduceCash($_voucherNo, $amount + $buyCashFee);
        }
        
        //用户余额表扣除金额
        $userCashAccountData = new CashAccountData();
        //判断现金是否足够挂单
        $userCashAccountRes = $userCashAccountData->isCash($amount + $buyCashFee - $voucherCash);
        if ($userCashAccountRes === false) {
            $lk->unlock($buyKey);
            DB::rollBack();
            return 806001;
        }
        //在途金额 = 在途金额 + $buyCashAmount 余额 = 余额 - $buyCashAmount
        $userCashAccountRes = $userCashAccountData->saveUserPendingAccount($amount + $buyCashFee);
        if ($userCashAccountRes['res'] === false) {
            $lk->unlock($buyKey);
            DB::rollBack();
            return false;
        }
        //写入用户流水表  在途 = + $buyCashAmount  支出 = $buyCashAmount
        $userCashJournalData = new CashJournalData();
        $userCashJournalRes = $userCashJournalData->add('', $transactionBuyNo, $userCashAccountRes, $amount + $buyCashFee, 'CJ03', 'CJT01', 0, 0, $this->session->userid, $date);
        if ($userCashJournalRes === false) {
            $lk->unlock($buyKey);
            DB::rollBack();
            return false;
        }
        //查询房产信息
        $region = '';

        //写入挂买单表
        $transactionBuyData = new TranactionBuyData();
        $transactionBuyRes = $transactionBuyData->add($count, $price, $coinType, $transactionBuyNo, $userCoinAccountInfo->id, $region, $buyCoinFeeRate, $buyCoinFeeType, $buyCashFeeRate, $buyCashFeetype, $sysConfigKey[UserTypeData::$CASH_BUY_FEE_HIDDEN], $sysConfigKey[UserTypeData::COIN_BUY_FEE_HIDDEN], $showBuyCount, $showBuyPrice, $buyCashFee, $toUserShowPrice, $toUserShowCount, $showCoinScale, $feePrice, $feeCount, $levelType);
        if ($transactionBuyRes === false) {
            $lk->unlock($buyKey);
            DB::rollBack();
            return false;
        }
        $lk->unlock($buyKey);
        DB::commit();
        return true;
    }
}
