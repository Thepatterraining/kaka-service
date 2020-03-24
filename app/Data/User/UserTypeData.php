<?php
namespace App\Data\User;

use App\Data\Activity\InfoData;
use App\Data\Activity\InvitationCodeData;
use App\Data\Activity\RegVoucherData;
use App\Data\Sys\ConfigData;
use App\Model\User\User;
use App\Data\IDataFactory;
use Illuminate\Support\Facades\DB;
use App\Data\User\CashAccountData;
use App\Data\Auth\AccessToken;

/**
 * user operation
 *
 * @author  geyunfei (geyunfei@kakamf.com)
 * @version 0.1
 */

class UserTypeData extends IDatafactory
{

    protected $modelclass = 'App\Model\User\UserType';

    const USER_TYPE=1;

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
    public static $PRODUCT_FREEZETIME = 'PRODUCT_FREEZETIME';
    public static $ACTIVITY_DEFULT_GROUP = 'ACTIVITY_DEFULT_GROUP';
    public static $SYS_FEE_ACCOUNT = 'SYS_FEE_ACCOUNT';
    public static $USER_ACTIVITY_DEFAULT = 'USER_ACTIVITY_DEFAULT';
    public static $CASH_RECHARGE_CHANNEL = 'CASH_RECHARGE_CHANNEL';
    public static $COIN_ACCURACY = 'COIN_ACCURACY';
    const COMPANY_NAME = 'COMPANY_NAME';
    const COMPANY_SIGN = 'COMPANY_SIGN';
    const COMPANY_AGENT = 'COMPANY_AGENT';
    const COMPANY_NO = 'COMPANY_NO';
    const COIN_BUY_FEE_HIDDEN = 'COIN_BUYFEEHIDDEN';
    const CASH_WECHAT_CHANNEL = 'CASH_WECHAT_CHANNEL';
    const CASH_ULPAY_CHANNEL = 'CASH_ULPAY_CHANNEL';
    const USER_CURRENTTYPE = 'USER_CURRENTTYPE';
    const USER_CURRENTRBTYPE = 'USER_CURRENTRBTYPE';

    const MARKET_CASH_BUY_FEE_TYPE = 'MARKET_CASH_BUYFEETYPE';
    const MARKET_CASH_SELL_FEE_TYPE = 'MARKET_CASH_SELLFEETYPE';
    const MARKET_COIN_BUY_FEE_TYPE = 'MARKET_COIN_BUYFEETYPE';
    const MARKET_COIN_SELL_FEE_TYPE = 'MARKET_COIN_SELLFEETYPE';
    const MARKET_COIN_BUY_FEE_RATE = 'MARKET_COIN_BUYFEERATE';
    const MARKET_COIN_SELL_FEE_RATE = 'MARKET_COIN_SELLFEERATE';
    const MARKET_CASH_BUY_FEE_RATE = 'MARKET_CASH_BUYFEERATE';
    const MARKET_CASH_SELL_FEE_RATE = 'MARKET_CASH_SELLFEERATE';
    const LEAST_MARKET_CASH_BUY_FEE = 'LEAST_MARKET_CASH_BUYFEE';
    const LEAST_MARKET_CASH_SELL_FEE = 'LEAST_MARKET_CASH_SELLFEE';

    const ULPAY_MIN_AMOUNT = 'ULPAY_MIN_AMOUNT';

    const DEFAULT_INVITATION_CODE = 'DEFAULT_INVITATION_CODE';
    const SELL_INTERVAL_MIN = 'SELL_INTERVAL_MIN';
    const SELL_INTERVAL_MAX = 'SELL_INTERVAL_MAX';


    const USER_TYPE_CASH_WITHDRAWAL_FEE_RATE = 'user_cash_withdrawalfeerate';
    const USER_TYPE_COIN_WITHDRAWAL_FEE_RATE = 'user_coin_withdrawalfeerate';
    const USER_TYPE_CASH_BUY_FEE_HIDDEN = 'user_cash_buyfeehidden';
    const USER_TYPE_COIN_BUY_FEE_HIDDEN = 'user_coin_buyfeehidden';
    const USER_TYPE_CASH_SELL_FEE_HIDDEN = 'user_cash_sellfeehidden';
    const USER_TYPE_COIN_SELL_FEE_HIDDEN = 'user_coin_sellfeehidden';
    const USER_TYPE_SELL_CASH_FEE_RATE = 'user_sell_cashfeerate';
    const USER_TYPE_SELL_CASH_FEE_TYPE = 'user_sell_cashfeetype';
    const USER_TYPE_SELL_COIN_FEE_RATE = 'user_sell_coinfeerate';
    const USER_TYPE_SELL_COIN_FEE_TYPE = 'user_sell_coinfeetype';
    const USER_TYPE_BUY_CASH_FEE_RATE = 'user_buy_cashfeerate';
    const USER_TYPE_BUY_CASH_FEE_TYPE = 'user_buy_cashfeetype';
    const USER_TYPE_BUY_COIN_FEE_RATE = 'user_buy_coinfeerate';
    const USER_TYPE_BUY_COIN_FEE_TYPE = 'user_buy_coinfeetype';
    const USER_TYPE_BUY_MARKET_CASH_FEE_RATE = 'user_buy_market_cashfeerate';
    const USER_TYPE_BUY_MARKET_CASH_FEE_TYPE = 'user_buy_market_cashfeetype';
    const USER_TYPE_BUY_MARKET_COIN_FEE_RATE = 'user_buy_market_coinfeerate';
    const USER_TYPE_BUY_MARKET_COIN_FEE_TYPE = 'user_buy_market_coinfeetype';
    const USER_TYPE_SELL_MARKET_CASH_FEE_RATE = 'user_sell_market_cashfeerate';
    const USER_TYPE_SELL_MARKET_CASH_FEE_TYPE = 'user_sell_market_cashfeetype';
    const USER_TYPE_SELL_MARKET_COIN_FEE_RATE = 'user_sell_market_coinfeerate';
    const USER_TYPE_SELL_MARKET_COIN_FEE_TYPE = 'user_sell_market_coinfeetype';
    const USER_TYPE_SELL_LEAST_MARKET_CASH_FEE = 'user_sell_least_market_cashfee';
    const USER_TYPE_BUY_LEAST_MARKET_CASH_FEE = 'user_buy_least_market_cashfee';
    const USER_TYPE_ULPAY_MIN_AMOUNT = 'ulpay_min_amount';

    const FEE_TYPE_FREE = 'FR00';
    const FEE_TYPE_IN = 'FR01';
    const FEE_TYPE_OUT = 'FR02';

    /**
     * 根据userid 和 用户类型取出系统配置
     *
     * @param   $userid
     * @param   $userType
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.15
     */
    public function getSysConfigs($userid = 0)
    {
        if ($userid > 0) {
            $userData = new UserData;
            $user = $userData->get($userid);
            $userType = $user->user_currenttype;
            if ($userType > 0) {
                $configs = $this->get($userType);
                return $configs;
            }
            else {
                $userType= self::USER_TYPE;
                $configs = $this->get($userType);
                return $configs;
            }
        }
        $sysConfigData = new ConfigData();
        $configs = $sysConfigData->getConfigs();
        
        return $configs;
    }

    public function dataConversion()
    {
        //查询用户类型
        $userid = $this->session->userid;
        return $this->getData($userid);
    }

    /**
     * 查询系统配置 
     *
     * @param  $userid 用户id
     * @author zhoutao
     * @date   2017.8.23
     */ 
    public function getData($userid)
    {
        //获取系统配置信息
        $userTypeData = new UserTypeData();
        $sysConfigs = $userTypeData->getSysConfigs();

        $sysConfigKey = [
                UserTypeData::$CASH_WITHDRAWAL_FEE_RATE => UserTypeData::USER_TYPE_CASH_WITHDRAWAL_FEE_RATE,
                UserTypeData::$CASH_BUY_FEE_RATE => UserTypeData::USER_TYPE_BUY_CASH_FEE_RATE,
                UserTypeData::$CASH_SELL_FEE_RATE => UserTypeData::USER_TYPE_SELL_CASH_FEE_RATE,
                UserTypeData::$CASH_BUY_FEE_HIDDEN => UserTypeData::USER_TYPE_CASH_BUY_FEE_HIDDEN,
                UserTypeData::$CASH_SELL_FEE_HIDDEN => UserTypeData::USER_TYPE_CASH_SELL_FEE_HIDDEN,
                UserTypeData::$COIN_WITHDRAWAL_FEE_RATE => UserTypeData::USER_TYPE_COIN_WITHDRAWAL_FEE_RATE,
                UserTypeData::$COIN_BUY_FEE_RATE => UserTypeData::USER_TYPE_BUY_COIN_FEE_RATE,
                UserTypeData::$COIN_SELL_FEE_RATE => UserTypeData::USER_TYPE_SELL_COIN_FEE_RATE,
                UserTypeData::$CASH_BUY_FEE_TYPE => UserTypeData::USER_TYPE_BUY_CASH_FEE_TYPE,
                UserTypeData::$CASH_SELL_FEE_TYPE => UserTypeData::USER_TYPE_SELL_CASH_FEE_TYPE,
                UserTypeData::$COIN_BUY_FEE_TYPE => UserTypeData::USER_TYPE_BUY_COIN_FEE_TYPE,
                UserTypeData::$COIN_SELL_FEE_TYPE => UserTypeData::USER_TYPE_SELL_COIN_FEE_TYPE,
                UserTypeData::$COIN_SELL_FEE_HIDDEN=>UserTypeData::USER_TYPE_COIN_SELL_FEE_HIDDEN,
                UserTypeData::COIN_BUY_FEE_HIDDEN => UserTypeData::USER_TYPE_COIN_BUY_FEE_HIDDEN,
                UserTypeData::$SHOW_COIN_SCALE=>'',
                UserTypeData::$PRODUCT_FREEZETIME=>'',
                UserTypeData::$ACTIVITY_DEFULT_GROUP=>'',
                UserTypeData::$SYS_FEE_ACCOUNT=>'',
                UserTypeData::$USER_ACTIVITY_DEFAULT=>'',
                UserTypeData::$CASH_RECHARGE_CHANNEL=>'',
                UserTypeData::$COIN_ACCURACY=>'',
                UserTypeData::COMPANY_NAME=>'',
                UserTypeData::COMPANY_SIGN=>'',
                UserTypeData::COMPANY_AGENT=>'',
                UserTypeData::COMPANY_NO=>'',
                UserTypeData::CASH_WECHAT_CHANNEL => '',
                UserTypeData::CASH_ULPAY_CHANNEL => '',
                UserTypeData::USER_CURRENTTYPE => '',
                UserTypeData::USER_CURRENTRBTYPE => '',
                UserTypeData::MARKET_CASH_BUY_FEE_TYPE=>'',
                UserTypeData::MARKET_CASH_SELL_FEE_TYPE=>'',
                UserTypeData::MARKET_COIN_BUY_FEE_TYPE=>'',
                UserTypeData::MARKET_COIN_SELL_FEE_TYPE=>'',
                UserTypeData::MARKET_COIN_BUY_FEE_RATE => '',
                UserTypeData::MARKET_COIN_SELL_FEE_RATE => '',
                UserTypeData::MARKET_CASH_BUY_FEE_RATE => '',
                UserTypeData::MARKET_CASH_SELL_FEE_RATE => '',
                UserTypeData::LEAST_MARKET_CASH_BUY_FEE => '',
                UserTypeData::LEAST_MARKET_CASH_SELL_FEE => '',
                UserTypeData::ULPAY_MIN_AMOUNT => '',
                UserTypeData::DEFAULT_INVITATION_CODE => '',
                UserTypeData::SELL_INTERVAL_MIN => '',
                UserTypeData::SELL_INTERVAL_MAX => '',
            ];
            
        foreach ($sysConfigs as $col => $val) {
            if (array_key_exists($val->config_key, $sysConfigKey)) {
                $sysConfigKey[$val->config_key] = $val->config_value;
            }
        }

        if ($userid > 0) {
            $sysConfigKey[UserTypeData::$CASH_WITHDRAWAL_FEE_RATE] = UserTypeData::USER_TYPE_CASH_WITHDRAWAL_FEE_RATE;
            $sysConfigKey[UserTypeData::$CASH_BUY_FEE_RATE] = UserTypeData::USER_TYPE_BUY_CASH_FEE_RATE;
            $sysConfigKey[UserTypeData::$CASH_SELL_FEE_RATE] = UserTypeData::USER_TYPE_SELL_CASH_FEE_RATE;
            $sysConfigKey[UserTypeData::$CASH_BUY_FEE_HIDDEN] = UserTypeData::USER_TYPE_CASH_BUY_FEE_HIDDEN;
            $sysConfigKey[UserTypeData::$CASH_SELL_FEE_HIDDEN] = UserTypeData::USER_TYPE_COIN_WITHDRAWAL_FEE_RATE;
            $sysConfigKey[UserTypeData::$COIN_WITHDRAWAL_FEE_RATE] = UserTypeData::USER_TYPE_BUY_COIN_FEE_RATE;
            $sysConfigKey[UserTypeData::$COIN_BUY_FEE_RATE] = UserTypeData::USER_TYPE_BUY_COIN_FEE_RATE;
            $sysConfigKey[UserTypeData::$COIN_SELL_FEE_RATE] = UserTypeData::USER_TYPE_SELL_COIN_FEE_RATE;
            $sysConfigKey[UserTypeData::$CASH_BUY_FEE_TYPE] = UserTypeData::USER_TYPE_BUY_CASH_FEE_TYPE;
            $sysConfigKey[UserTypeData::$CASH_SELL_FEE_TYPE] = UserTypeData::USER_TYPE_SELL_CASH_FEE_TYPE;
            $sysConfigKey[UserTypeData::$COIN_BUY_FEE_TYPE] = UserTypeData::USER_TYPE_BUY_COIN_FEE_TYPE;
            $sysConfigKey[UserTypeData::$COIN_SELL_FEE_TYPE] = UserTypeData::USER_TYPE_SELL_COIN_FEE_TYPE;
            $sysConfigKey[UserTypeData::$COIN_SELL_FEE_HIDDEN] = UserTypeData::USER_TYPE_COIN_SELL_FEE_HIDDEN;
            $sysConfigKey[UserTypeData::COIN_BUY_FEE_HIDDEN] = UserTypeData::USER_TYPE_COIN_BUY_FEE_HIDDEN;
            $sysConfigKey[UserTypeData::MARKET_CASH_BUY_FEE_TYPE] = UserTypeData::USER_TYPE_BUY_MARKET_CASH_FEE_TYPE;
            $sysConfigKey[UserTypeData::MARKET_CASH_SELL_FEE_TYPE] = UserTypeData::USER_TYPE_SELL_MARKET_CASH_FEE_TYPE;
            $sysConfigKey[UserTypeData::MARKET_COIN_BUY_FEE_TYPE] = UserTypeData::USER_TYPE_BUY_MARKET_COIN_FEE_TYPE;
            $sysConfigKey[UserTypeData::MARKET_COIN_SELL_FEE_TYPE] = UserTypeData::USER_TYPE_SELL_MARKET_COIN_FEE_TYPE;
            $sysConfigKey[UserTypeData::MARKET_COIN_BUY_FEE_RATE] = UserTypeData::USER_TYPE_BUY_MARKET_COIN_FEE_RATE;
            $sysConfigKey[UserTypeData::MARKET_COIN_SELL_FEE_RATE] = UserTypeData::USER_TYPE_SELL_MARKET_COIN_FEE_RATE;
            $sysConfigKey[UserTypeData::MARKET_CASH_BUY_FEE_RATE] = UserTypeData::USER_TYPE_BUY_MARKET_CASH_FEE_RATE;
            $sysConfigKey[UserTypeData::MARKET_CASH_SELL_FEE_RATE] = UserTypeData::USER_TYPE_SELL_MARKET_CASH_FEE_RATE;
            $sysConfigKey[UserTypeData::LEAST_MARKET_CASH_BUY_FEE] = UserTypeData::USER_TYPE_BUY_LEAST_MARKET_CASH_FEE;
            $sysConfigKey[UserTypeData::LEAST_MARKET_CASH_SELL_FEE] = UserTypeData::USER_TYPE_SELL_LEAST_MARKET_CASH_FEE;
            $sysConfigKey[UserTypeData::ULPAY_MIN_AMOUNT] = UserTypeData::USER_TYPE_ULPAY_MIN_AMOUNT;

            $sysConfigs = $userTypeData->getSysConfigs($userid);
            if (!empty($sysConfigs)) {
                $sysConfigs = $sysConfigs->toArray();
                foreach ($sysConfigKey as $col => $val) {
                    if (array_key_exists($val, $sysConfigs)) {
                        $sysConfigKey[$col] = $sysConfigs[$val];
                    }
                }
            }
        }

        return $sysConfigKey;
    }

    /**
     * 查询买卖手续费率
     *
     * @param  $userid 用户id
     * @author zhoutao
     * @date   2017.8.23
     */ 
    public function getOrderFee($userid)
    {
        $sysConfigs = $this->getData($userid);
        
        $buyCashFeeRate = $sysConfigs[UserTypeData::MARKET_CASH_BUY_FEE_RATE];
        if ($sysConfigs[UserTypeData::MARKET_CASH_BUY_FEE_TYPE] == self::FEE_TYPE_FREE) {
            $buyCashFeeRate = 0;
        }
        
        $sellCashFeeRate = $sysConfigs[UserTypeData::MARKET_CASH_SELL_FEE_RATE];
        if ($sysConfigs[UserTypeData::MARKET_CASH_SELL_FEE_TYPE] == self::FEE_TYPE_FREE) {
            $sellCashFeeRate = 0;
        }

        $res['buyCashFeeRate'] = floatval($buyCashFeeRate);
        $res['sellCashFeeRate'] = floatval($sellCashFeeRate);
        return $res;
    }
}
