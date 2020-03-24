<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;


/**
 * 系统的错误类
 *
 * geyunfei@kakamf.com
 * Sep 25th ,2017 
 * 加入微信验证码相关的
 */

class ErrorData extends IDatafactory
{
    public static $USER_NOT_FOUND = 801001;
    public static $USER_NOT_LOGIN=801002;
    public static $USRR_PWD_WRONG = 801003;
    public static $USER_PAY_WRONG =801004;
    public static $PAY_PWD_REQUIRED =801005;
    public static $CHECK_PWD_PAY = 801006;
    public static $SAVE_FALSE = 801007;
    public static $ACTIVITY_CODE_ERROR = 801010;
    public static $USER_PWD_UNIQUE = 801011;
    public static $USER_REQUIRED = 801013;
    public static $USER_LOGIN_OTHER = 801014;
    public static $VERIFY_REQUIRED = 801018;
    public static $USER_IDNO_REQUIRED = 801019;
    public static $AUTH_GROUP_USER_UNIQUE = 801023;
    public static $AUTH_GROUP_USER_REQUIRED = 801024;
    public static $AUTH_GROUP_USER_NOT_FOUND = 801025;
    const USER_IDNO_NOT_FOUND = 801028;
    const USER_STATUS_FROZEN = 801029;
    
    const NOT_FOUND_NO = 802006;
    public static $AMOUNT_TWO_DECIMAL = 802007;

    public static $VERIFY_SEND_OUT_FALSE = 803001;
    public static $VERIFY_FALSE = 803002;
    public static $ACTIVITY_CODE_UNIQUE = 803004;
    const OPER_FREQUENT = 803005;
    const IMG_CODE_ERROR = 803006;


    public static $TOKEN_NOT_FOUND = 800001;
    public static $TOKEN_TIMEOUT    = 800002;
    

    public static $ACTIVITY_UNIQUE = 809003;
    public static $ACTIVITY_REQUIRED = 809002;
    public static $ITEM_NOT_FOUND = 809001;
    public static $ACTIVITY_CODE_COUNT = 807001;

    public static $WECHAT_USER_NOT_BIND = 901001;
    
    public static $USER_CASH_NOT_ENOUGH = 806001;
    public static $LEVEL_ONE_NOT_BUY = 806002;
    const RECHARGE_AMOUNT_GT_ZERO = 806004; //充值金额大于0
    public static $BUY_COUNT_LARGE = 806005;
    public static $SELL_COUNT_NOT_ENOUGH = 806006;
    public static $AMOUNT_ENOUGH = 806007;
    public static $SELL_COUNT_LARGE = 806008;
    public static $BUY_SURPLUS_COUNT = 806009;
    public static $WITH_MAX_FREQUENCY = 806010;
    public static $SELL_PRICE_NOT_LARGE = 806011;
    public static $SELL_PRICE_NOT_SMALL = 806012;
    public static $WITH_AMOUNT_MIN_ONE_HUNDRED = 806013;
    public static $SELL_PRODUCT_NOT_JURISDICTION = 806014;
    const LEVEL_ONE_NOT_SELL = 806015;
    const PRICE_NOT_INTERVAL = 806016;
    const SELL_COUNT_NOT_FLOUT = 806017;
    
    public static $USER_IDNO_ERROR = 801016;
    public static $USER_PAY_PWD_REQUIRED = 801017;

    public static $BANK_CARD_FALSE = 808004;

    public static $ACTIVITY_UNIQUE_FIRST = 809004;
    const ACTIVITY_CODE_NOT_FOUND_USER = 809005;
    public static $TIME_ERROR = 807002;

    const USER_FROZENED = 810001;
    const USER_UNFROZENED = 810002;
    
    public static $NO_RUN_FUNCTION = 800110;
    public static $WRONG_CLASS = 800111; 


    const UPLOAD_FILE_EMPTY = 902001;
    const UPLOAD_FILE_ERROR = 902002;
    const UPLOAD_FILE_TYPE_ERROR = 902003;
    const UPLOAD_FILE_SIZE_MAX = 902004;
    const UPLOAD_FILE_SIZE_EMPTY = 902005;

    const ULPAY_MIN_AMOUNT = 903001;

    const ERROR_EXPRESSION = 904001;

    const ERROR_ITEM_NO = 905001;

    const APP_KEY_ERROR = 906001;


    const AUTH_CODE_TIMEOUT = 801031;
    const AUTH_CODE_ERROR = 801032;

    const BANNER_NOT_EXIST = 902101;
    
    const BANNER_TYPE_NOT_EXIST = 902006;
    const BANNER_INDEX_NOT_EXIST = 902007;
    const RESOURCE_NOT_EXIST = 902008;
    const MODEL_NOT_EXIST = 902009;

    const COINADDR_ADDR_REQUIRED = 907001;
    const COINADDR_USERNAME_REQUIRED = 907002;
    const COINADDR_USERIDNO_REQUIRED = 907003;
    const COINADDR_MOBILE_REQUIRED = 907004;

    protected $modelclass = 'App\Model\Sys\Error';
    
    public function getErrorByCode($code)
    {

        $modelclass = $this->modelclass;
        return $modelclass::where('error_code', $code)->first();
    }
}
