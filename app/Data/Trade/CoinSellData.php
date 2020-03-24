<?php
namespace App\Data\Trade;

use App\Data\Coin\ItemData;
use App\Data\Project\ProjectInfoData;
use App\Data\User\CoinJournalData;
use App\Data\User\UserData;
use App\Data\User\UserTypeData;
use App\Model\User\User;
use App\Data\IDataFactory;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use App\Data\User\CoinAccountData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Data\Sys\LockData;
use App\Data\Sys\ErrorData;

class CoinSellData extends IDatafactory
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
    public static $SHOW_COIN_SCALE = 'SHOW_COIN_SCALE';

    public static $SELL_LEVEL_TYPE_ORDINARY = 'SL00';
    public static $SELL_LEVEL_TYPE_ONE = 'SL01';

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
    public function __construct($getCashFee = CoinSellData::GET_FEE)
    {   
        parent::__construct();
        $this->_getFeeFunc = $getCashFee;
    }


    /**
     * 挂卖单业务
     *
     * @param   $count 卖数量
     * @param   $price 价格
     * @param   $coin 币种
     * @param   $userCoinJournalNo 用户代币流水表单据号
     * @param   $transactionSellNo 卖单单据号
     * @author  zhoutao
     * @version 0.1
     * 
     * 把地区默认为空
     * @author  zhoutao
     * @date    2017.10.19
     */
    public function addSell($count, $price, $coin, $userCoinJournalNo, $transactionSellNo, $date)
    {
        DB::beginTransaction();
        $levelType = 'SL00';
        //用户代币余额表扣除金额
        $userCoinAccountData = new CoinAccountData();
        //判断有没有足够的代币可以卖
        $userCoinAccountRes = $userCoinAccountData->isCash($coin, $count);
        if ($userCoinAccountRes === false) {
            DB::rollBack();
            return false;
        }

        //判断是否是一级市场的卖单
        $primaryRes = $userCoinAccountData->isPrimary($coin);
        if ($primaryRes === false) {
            $levelType = 'SL01'; //一级市场
        }

        //在途金额 = 在途金额 + 卖出数量 余额 = 余额 - 卖出数量
        $userCoinAccountRes = $userCoinAccountData->saveUserCoin($coin, $count, null, $date);
        if ($userCoinAccountRes['res'] === false) {
            DB::rollBack();
            return false;
        }
        //写入用户代币流水表 在途 = + 卖出数量
        $userCoinJournalData = new CoinJournalData();
        $userCoinJournalRes = $userCoinJournalData->addCoinJournal($userCoinAccountRes, $coin, $userCoinJournalNo, $count, $transactionSellNo, 'CJT01', 'UOJ07', 0, 0, null, $date);
        if ($userCoinJournalRes === false) {
            DB::rollBack();
            return false;
        }
        //查询房产信息
        $region = '';

        //写入卖单表
        $transactionSellData = new TranactionSellData();
        $sellRes = $transactionSellData->addSell($count, $price, $coin, $transactionSellNo, $userCoinAccountRes['id'], $region, $levelType);
        if ($sellRes === false) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }

    /**
     * 获取一级卖方手续费信息
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

        $res['sellCoinFeetype'] = $sysConfigKey[UserTypeData::$COIN_SELL_FEE_TYPE];
        $res['sellCoinFeeRate'] = $sysConfigKey[UserTypeData::$COIN_SELL_FEE_RATE];
        $res['sellCashFeetype'] = $sysConfigKey[UserTypeData::$CASH_SELL_FEE_TYPE];
        $res['sellCashFeeRate'] = $sysConfigKey[UserTypeData::$CASH_SELL_FEE_RATE];
        $res['leastMarketCashFee'] = 0;
        return $res;
    }

    /**
     * 获取二级卖方手续费信息
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

        $res['sellCoinFeetype'] = $sysConfigKey[UserTypeData::MARKET_COIN_SELL_FEE_TYPE];
        $res['sellCoinFeeRate'] = $sysConfigKey[UserTypeData::MARKET_COIN_SELL_FEE_RATE];
        $res['sellCashFeetype'] = $sysConfigKey[UserTypeData::MARKET_CASH_SELL_FEE_TYPE];
        $res['sellCashFeeRate'] = $sysConfigKey[UserTypeData::MARKET_CASH_SELL_FEE_RATE];
        $res['leastMarketCashFee'] = $sysConfigKey[UserTypeData::LEAST_MARKET_CASH_SELL_FEE];
        return $res;
    }

    /**
     * 二级市场挂卖单
     *
     * @author zhoutao
     * @date   2017.8.18
     * 
     * 区分了一级 二级的手续费
     * @author zhoutao
     * @date   2017.9.4
     * 
     * 比例因子改成从projectInfoData获取
     * @author zhoutao
     * @date   2017.10.19
     * 
     * 增加卖出所有剩余小数
     * @author zhoutao
     * @date   2017.10.30
     */ 
    public function marketSell($sellCoinCount, $price, $coinType, $userCoinJournalNo, $transactionSellNo, $date)
    {
        $lk = new LockData();
        $sellKey = 'createSell' . $coinType;
        $lk->lock($sellKey);

        $userCoinAccountData = new CoinAccountData;

        //获取系统配置信息
        $userTypeData = new UserTypeData();
        $sysConfigKey = $userTypeData->getData($this->session->userid);

        //取出比例因子
        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->getByNo($coinType);
        $showCoinScale = $projectInfo->project_scale;

        //如果数量为0,说明没有传过来数量，取用户所有剩余数量
        if ($sellCoinCount == 0) {
            $sellCoinCount = $userCoinAccountData->getUserCoinCash($coinType);
            $sellCoinCount = bcdiv($sellCoinCount, $showCoinScale, 9);
            //如果剩余数量小于等于 0 或者 大于等于1 返回错误
            if ($sellCoinCount <= 0 || $sellCoinCount >= 1) {
                $lk->unlock($sellKey);
                return ErrorData::SELL_COUNT_NOT_FLOUT;
            }

        }

        //显示价格 = 输入价格 显示数量 = 输入数量 / 比例因子
        $toUserShowPrice = $price;
        $toUserShowCount = $sellCoinCount;

        //价格 = 显示价格 ／ 比例因子
        $price = $toUserShowPrice / $showCoinScale;
        $sellCoinCount = $toUserShowCount * $showCoinScale;
        
        $res = $this->addSellOrder($sellCoinCount, $price, $coinType, $userCoinJournalNo, $transactionSellNo, $date, $toUserShowPrice, $toUserShowCount);
        
        $lk->unlock($sellKey);
        return $res === false ? ErrorData::$USER_CASH_NOT_ENOUGH : $res;
    }

    /**
     * 挂卖单
     *
     * @param   $sellCoinCount 数量
     * @param   $price 单价
     * @param   $coinType 代币类型
     * @param   $userCoinJournalNo 用户代币流水号
     * @param   $transactionSellNo 卖单号
     * @param   $date 时间
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.17
     * 
     * 区分了一级 二级的手续费 增加了最小手续费
     * @author  zhoutao
     * @date    2017.9.4
     * 
     * 加入了redis锁
     * @author  zhoutao
     * @date    2017.9.4
     * 
     * 修改比例因子和地区的获取
     * @author  zhoutao
     * @date    2017.10.19
     */
    private function addSellOrder($sellCoinCount, $price, $coinType, $userCoinJournalNo, $transactionSellNo, $date, $toUserShowPrice, $toUserShowCount)
    {
        DB::beginTransaction();
        $levelType = $this::$SELL_LEVEL_TYPE_ORDINARY;
        // //查询用户类型
        // $userid = $this->session->userid;
        // $userData = new UserData();
        // $userInfo = $userData->get($userid);
        // $userType = $userInfo->user_type;

        // //获取系统配置信息
        // $userTypeData = new UserTypeData();
        // $sysConfigs = $userTypeData->getSysConfigs($userid,$userType);

        // $sysConfigKey = [
        //     $this::$CASH_WITHDRAWAL_FEE_RATE => '',
        //     $this::$CASH_BUY_FEE_RATE => '',
        //     $this::$CASH_SELL_FEE_RATE => '',
        //     $this::$CASH_BUY_FEE_HIDDEN => '',
        //     $this::$CASH_SELL_FEE_HIDDEN => '',
        //     $this::$COIN_WITHDRAWAL_FEE_RATE => '',
        //     $this::$COIN_BUY_FEE_RATE => '',
        //     $this::$COIN_SELL_FEE_RATE => '',
        //     $this::$CASH_BUY_FEE_TYPE => '',
        //     $this::$CASH_SELL_FEE_TYPE => '',
        //     $this::$COIN_BUY_FEE_TYPE => '',
        //     $this::$COIN_SELL_FEE_TYPE => '',
        //     $this::$COIN_SELL_FEE_HIDDEN=>'',
        //     $this::$SHOW_COIN_SCALE=>'',
        // ];
        // foreach ($sysConfigs as $col => $val) {
        //     if (array_key_exists($val->config_key,$sysConfigKey)) {
        //         $sysConfigKey[$val->config_key] = $val->config_value;
        //     }
        // }

        //获取系统配置信息
        $userTypeData = new UserTypeData();
        $userType = $userTypeData->getData($this->session->userid);

        //取出比例因子
        $projectInfoData = new ProjectInfoData;
        $projectInfo = $projectInfoData->getByNo($coinType);
        $showCoinScale = $projectInfo->project_scale;

        // //取出比例因子
        // $showCoinScale = $sysConfigKey[$this::$SHOW_COIN_SCALE];

        // //显示价格 = 输入价格 显示数量 = 输入数量
        // $toUserShowPrice = $price;
        // $toUserShowCount = $sellCoinCount;

        // //价格 = 显示价格 ／ 比例因子 数量 = 显示数量 * 比例因子
        // $price = $toUserShowPrice / $showCoinScale;
        // $sellCoinCount = $toUserShowCount * $showCoinScale;

        //用户代币余额表扣除金额
        $userCoinAccountData = new CoinAccountData();
        //判断有没有足够的代币可以卖
        $userCoinAccountRes = $userCoinAccountData->isCash($coinType, $sellCoinCount);
        if ($userCoinAccountRes === false) {
            return false;
        }
        //判断是否是一级市场的卖单
        $primaryRes = $userCoinAccountData->isPrimary($coinType);
        $this->_getFeeFunc = CoinSellData::GET_MARKET_FEE;
        if ($primaryRes === false) {
            $levelType = $this::$SELL_LEVEL_TYPE_ONE; //一级市场
            $this->_getFeeFunc = CoinSellData::GET_FEE;
        }
        
        $getFeeFunc = $this->_getFeeFunc;
        $sellFees = $this->$getFeeFunc($this->session->userid);
        $leastMarketCashFee = $sellFees['leastMarketCashFee'];

        $sellCoinFeetype = $sellFees['sellCoinFeetype'];//$userType[UserTypeData::$COIN_SELL_FEE_TYPE];
        $sellCoinFeeRate = $sellFees['sellCoinFeeRate'];//$userType[UserTypeData::$COIN_SELL_FEE_RATE];
        switch ($sellCoinFeetype) {
        case $this::$SELL_FEE_TYPE_FREE:
            $sellCoinFee = 0;
            $sellCoinAmmount = $sellCoinCount;
            $showCoinCount = $sellCoinCount;
            break;
        case $this::$SELL_FEE_TYPE_IN:
            //价内
            $sellCoinFee = 0;
            $sellCoinAmmount = $sellCoinCount;
            $showCoinCount = $sellCoinCount;
            break;
        case $this::$SELL_FEE_TYPE_OUT:
            //价外
            $sellCoinFee = $sellCoinCount * $sellCoinFeeRate / (1 + $sellCoinFeeRate);
            $sellCoinAmmount = $sellCoinCount;
            $showCoinCount = $sellCoinCount * (1 + $sellCoinFeeRate);
            break;
        default:
            break;
        }

        $sellCashFeeRate = $sellFees['sellCashFeeRate'];//$userType[UserTypeData::$CASH_SELL_FEE_RATE];
        $sellCashFeetype = $sellFees['sellCashFeetype'];//$userType[UserTypeData::$CASH_SELL_FEE_TYPE];
        switch ($sellCashFeetype) {
        case $this::$SELL_FEE_TYPE_FREE:
            $showCoinPrice = $price;
            break;
        case $this::$SELL_FEE_TYPE_IN:
            //价内
            $showCoinPrice = $price;
            break;
        case $this::$SELL_FEE_TYPE_OUT:
            //价外
            $showCoinPrice = $price * (1 + $sellCashFeeRate);
            break;
        default:
            break;
        }

        //处理代币手续费
        $sellCoinFee = floor($sellCoinFee * 1000) / 1000;
        //给带手续费的显示价格和数量赋值
        $feePrice = $showCoinPrice * $showCoinScale;
        $feeCount = $showCoinCount / $showCoinScale;

        
        //在途 = 在途 + $sellCoinAmmount 余额 = 余额 - $sellCoinAmmount
        $userCoinAccountRes = $userCoinAccountData->saveUserCoin($coinType, $sellCoinAmmount, null, $date);
        if ($userCoinAccountRes['res'] === false) {
            DB::rollBack();
            return false;
        }

        //写入用户代币流水表 在途 = + $sellCoinAmmount
        $userCoinJournalData = new CoinJournalData();
        $userCoinJournalRes = $userCoinJournalData->addCoinJournal($userCoinAccountRes, $coinType, $userCoinJournalNo, $sellCoinAmmount, $transactionSellNo, 'CJT01', 'UOJ07', 0, 0, null, $date);
        if ($userCoinJournalRes === false) {
            DB::rollBack();
            return false;
        }

        //查询房产信息
        $region = '';

        //写入卖单表
        $transactionSellData = new TranactionSellData();
        $sellRes = $transactionSellData->add($sellCoinAmmount, $price, $coinType, $transactionSellNo, $userCoinAccountRes['id'], $region, $levelType, $sellCashFeetype, $sellCoinFeeRate, $sellCoinFeetype, $sellCashFeeRate, $userType[UserTypeData::$CASH_SELL_FEE_HIDDEN], $userType[UserTypeData::$COIN_SELL_FEE_HIDDEN], $showCoinCount, $showCoinPrice, $sellCoinFee, $toUserShowPrice, $toUserShowCount, $showCoinScale, $feePrice, $feeCount);
        if ($sellRes === false) {
            DB::rollBack();
            return false;
        }
        DB::commit();
        return true;
    }

    /**
     * 撤销卖单操作
     * 
     * @param   $transactionSellNo 卖单单据号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.8.22
     * 
     * 增加了redis 锁
     * @author  zhoutao
     * @date    2017.10.10
     */
    public function revokeSell($transactionSellNo, $date)
    {
        $lk = new LockData();
        $key = 'revokeSell' . $transactionSellNo;
        $lk->lock($key);

        DB::beginTransaction();
        //更新卖单表
        $transactionSellData = new TranactionSellData();
        $sellInfo = $transactionSellData->getByNo($transactionSellNo);
        $userid = $sellInfo->sell_userid;
        if ($sellInfo->sell_status == TranactionSellData::NEW_SELL_STATUS || $sellInfo->sell_status == TranactionSellData::PARTIAL_TRANSACTION_STATUS) {
            $sellRes = $transactionSellData->saveSell($transactionSellNo, $userid);
            if ($sellRes['res'] === false) {
                DB::rollBack();
                $lk->unlock($key);
                return false;
            }

            $count = $sellRes['amount'];
            $coinType = $sellRes['coinType'];

            //用户代币余额表增加金额  在途金额 = 在途金额 - （挂单数量 - 成交数量) 余额 = 余额 + （挂单数量 - 成交数量)
            $userCoinAccountData = new CoinAccountData();
            $coinRes = $userCoinAccountData->increaseCashReducePending($coinType, $transactionSellNo, $count, $count, $userid, CoinJournalData::ORDER_TYPE, CoinJournalData::REVOKE_STATUS, $date);
            
        }
        DB::commit();
        $lk->unlock($key);
        
        return true;
    }
}
