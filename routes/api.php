<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteserviceProvider within a group which
| is assigned the "api" middleware group. enjoy building your API!
|
*/
Route::post("auth/login","Auth\Login")->name('login')->middleware('token');
Route::post("auth/token/require","Auth\RequireTokenController");
Route::post("auth/logout","Auth\Logout");
Route::post("auth/reg","User\RegUser")->middleware('token');
Route::post("auth/savepwd","User\SaveUserPwd")->middleware('token')->middleware('chkmobileverify');
Route::post("auth/saveuserpwd","User\SaveUserNewPwd")->middleware('login');
Route::post("auth/savepaypwd","User\SaveUserPayPwd")->middleware('login')->middleware('chkmobileverify');
Route::post("auth/savephone","User\SaveUserPhone")->middleware('login')->middleware('chkmobileverify');
Route::post("auth/token/adminrequire","Admin\RequireTokenController");



/*****************************   管理员   **************************************/
//管理员登陆
Route::post("admin/login","Admin\Login")->middleware('admintoken')->middleware("checkcode");
Route::post("admin/adduser","Admin\AddAuthUser")->middleware('admin');
Route::post("admin/checkcode","CheckAuth\WechatCheckCode")->middleware('admintoken');
//修改管理员信息
Route::post("admin/saveuser","Admin\SaveAuthUser")->middleware('admin');
//重置密码 默认重置为123456
Route::post("admin/saveuserpwd","Admin\SaveAuthUserPwd")->middleware('admin');
//删除管理员
Route::post("admin/deluser","Admin\DeleteAuthUser")->middleware('admin');
//查询管理员列表
Route::post("admin/getauthuserlist","Admin\GetAuthUserList")->middleware('admin');
//查询管理员详细 修改时候用
Route::post("admin/getauthuserinfo","Admin\GetAuthUserInfo")->middleware('admin');
//修改管理员密码
Route::post("admin/savepwd","Admin\SaveAuthPwd")->middleware('admin');
//添加管理员邮箱
Route::post("admin/addauthemail","Admin\AddAuthEmail")->middleware('admin');

Route::post("sys/getbank","Sys\GetBank");
Route::post("sys/getcashaccount","Sys\GetCashAccount");
Route::post("sys/getcoinaccount","Sys\GetCoinAccount");
Route::post("sys/getdictionary","Sys\GetDictionary");
Route::post("sys/geterror","Sys\GetError");

Route::post("sys/getloginlog","Sys\GetLoginLog");
Route::post("sys/getmessage","Sys\GetMessage");
Route::post("sys/getnotify","Sys\GetNotify");
Route::post("sys/getsmslog","Sys\GetSmsLog");
Route::post("sys/getuser","Sys\GetUser");
Route::post("sys/deleteaccount","Sys\DeleteAccount");
Route::post("sys/deletebank","Sys\DeleteBank");
Route::post("sys/deletecashaccount","Sys\DeleteCashAccount");
Route::post("sys/deletecoinaccount","Sys\DeleteCoinAccount");
Route::post("sys/deletedictionary","Sys\DeleteDictionary");
Route::post("sys/deleteerror","Sys\DeleteError");
Route::post("sys/deletelog","Sys\DeleteLog");
Route::post("sys/deleteloginlog","Sys\DeleteLoginLog");
Route::post("sys/deletemessage","Sys\DeleteMessage");
Route::post("sys/deletenotify","Sys\DeleteNotify");
Route::post("sys/deletesmslog","Sys\DeleteSmsLog");
Route::post("sys/deleteuser","Sys\DeleteUser");
Route::post("sys/addaccount","Sys\AddAccount");
Route::post("sys/addbank","Sys\AddBank");
Route::post("sys/addcashaccount","Sys\AddCashAccount");
Route::post("sys/addcoinaccount","Sys\AddCoinAccount");
Route::post("sys/adddictionary","Sys\AddDictionary");
Route::post("sys/adderror","Sys\AddError");
Route::post("sys/addlog","Sys\AddLog");
Route::post("sys/addloginlog","Sys\AddLoginLog");
Route::post("sys/addmessage","Sys\AddMessage");
Route::post("sys/addnotify","Sys\AddNotify");
Route::post("sys/addsmslog","Sys\AddSmsLog");
Route::post("sys/adduser","Sys\AddUser");
Route::post("sys/saveaccount","Sys\SaveAccount");
Route::post("sys/savebank","Sys\SaveBank");
Route::post("sys/savecashaccount","Sys\SaveCashAccount");
Route::post("sys/savecoinaccount","Sys\SaveCoinAccount");
Route::post("sys/savedictionary","Sys\SaveDictionary");
Route::post("sys/saveerror","Sys\SaveError");
Route::post("sys/savelog","Sys\SaveLog");
Route::post("sys/saveloginlog","Sys\SaveLoginLog");
Route::post("sys/savemessage","Sys\SaveMessage");
Route::post("sys/savenotify","Sys\SaveNotify");
Route::post("sys/savesmslog","Sys\SaveSmsLog");
Route::post("sys/saveuser","Sys\SaveUser");


//一般管理
Route::post("admin/querylog","Sys\QueryLog")->middleware('admin');
Route::post("admin/querylogin","Sys\QueryLoginlog")->middleware('admin');
/*************************    充值提现 ***********************************/
//现金充值接口
Route::post("cash/recharge","Cash\UserCashRechage")->middleware('login')->middleware('chkmobileverify')->middleware('checkaccount');
Route::post("cash/createremittance","Cash\CreateRemittance")->middleware('login');
Route::post("cash/rechargconfirm","Cash\CashRechageConfirm")->middleware('admin')->middleware("checkcode");
//代币充值 --- 一级市场充值
Route::post("coin/rechage","Coin\Recharge")->middleware('admin');
//普通充值
Route::post("coin/rechagecoin","Coin\RechargeCoin")->middleware('login');
Route::post("coin/rechargconfirm","Coin\RechargeConfirm")->middleware('admin');
//现金提现接口
Route::post("cash/withdrawal","Cash\CashWithdrawal")->middleware('login')->middleware('chkstatus')->middleware('chkpaypwd')->middleware('checkaccount');
Route::post("cash/withdrawalconfirm","Cash\CashWithdrawalConfirm")->middleware('admin');
//提现代币接口
Route::post("coin/withdrawal","Coin\Withdrawal")->middleware('login')->middleware('chkstatus')->middleware('chkpaypwd')->middleware('checkaccount');
Route::post("coin/withdrawalconfirm","Coin\WithdrawalConfirm")->middleware('admin');

/****************  查询充值提现****************/
//管理员查询充值信息
Route::post("cash/getrecharge","Admin\GetRechargeInfo")->middleware('admin');
Route::post("cash/getrechargelist","Admin\GetRechargeList")->middleware('admin');//->middleware('login');
//管理员查询提现记录
Route::post("cash/getwithdrawal","Admin\GetWithdrawalInfo")->middleware('admin');
Route::post("cash/getwithdrawallist","Admin\GetWithdrawalList")->middleware('admin');;
//管理员查询充值代币
Route::post("admin/getrechargelist","Admin\GetCoinRechargeList")->middleware('admin');
//管理员查询提现代币
Route::post("admin/getwithdrawallist","Admin\GetCoinWithdrawalList")->middleware('admin');

//查询用户充值现金信息
Route::post("user/getrecharge","User\GetRechargeInfo")->middleware('login');
Route::post("user/getrechargelist","User\GetRechargeList")->middleware('login');
//查询用户充值代币记录
Route::post("user/getcoinrechargelist","User\GetCoinRechargeList")->middleware('login');
//查询用户提现记录
Route::post("user/getwithdrawal","User\GetWithdrawalInfo")->middleware('login');
Route::post("user/getwithdrawallist","User\GetWithdrawalList")->middleware('login');
//查询用户提现代币记录
Route::post("user/getcoinwithdrawallist","User\GetCoinWithdrawalList")->middleware('login');
//更改充值金额
Route::post("admin/cash/rechargechange","Cash\CashRechargeChange")->middleware('admin');

//充值金额抹零
Route::post("admin/cash/rechargeloor","Cash\CashRechargeFloor")->middleware('admin');


//充值抹零

/****************  查询交易****************/
//用户查询买单记录
Route::post("user/gettranactionbuy","User\GetTranactionBuyList")->middleware('login');
Route::post("user/gettranactionbuyinfo","User\GetTranactionBuyInfo")->middleware('login');
//用户查询卖单记录
Route::post("user/gettranactionsell","User\GetTranactionSellList")->middleware('login');
Route::post("user/gettranactionsellinfo","User\GetTranactionSellInfo")->middleware('login');
//用户查询交易记录
Route::post("user/gettranactionorder","User\GetTranactionOrderList");
//管理员查询买单记录
Route::post("admin/gettranactionbuy","Admin\GetTranactionBuyList")->middleware('admin');
Route::post("admin/gettranactionbuyinfo","Admin\GetTranactionBuyInfo")->middleware('admin');
//管理员查询卖单记录
Route::post("admin/gettranactionsell","Admin\GetTranactionSellList")->middleware('admin');
Route::post("admin/gettranactionsellinfo","Admin\GetTranactionSellInfo")->middleware('admin');
//管理员查询交易记录
Route::post("admin/gettranactionorder","Admin\GetTranactionOrderList")->middleware('admin');
Route::post("admin/gettranactionorderinfo","Admin\GetTranactionOrderInfo")->middleware('admin');
//管理员查询所有用户现金流水
Route::post("admin/getusercashlist","Admin\GetUserCashList")->middleware('admin');
//管理员查询所有用户代币流水
Route::post("admin/getusercoinlist","Admin\GetUserCoinList")->middleware('admin');
//用户卖单时查询一些信息
Route::post("trade/getsellorder","User\GetCoinSell")->middleware('login');
//查询所有用户卖单记录
Route::post("trade/gettranactionsell","User\GetTranactionSell")->middleware('token');
//用户查询自己的交易记录
Route::post("trade/getorderlist","User\GetOrderList")->middleware('login');
//交易回调
Route::post("trade/getorderlist","User\GetOrderList");


/*************************    活动后台   ***********************************/
//查询现金券类型
Route::post("admin/getvouchertype","Admin\GetVoucherInfoType")->middleware('admin');
//查询所有现金券
Route::post("admin/getvoucher","Admin\GetVoucher")->middleware('admin');
//添加现金券现金券
Route::post("admin/addvoucher","Admin\AddVoucher")->middleware('admin');
//查询活动类型
Route::post("admin/getactivitype","Admin\GetActivityType")->middleware('admin');
//查询活动状态
Route::post("admin/getactivistatus","Admin\GetActivityStatus")->middleware('admin');
//添加活动
Route::post("admin/addactivi","Admin\AddActivity")->middleware('admin');
//查询活动子表的类型
Route::post("admin/getactivitemtype","Admin\GetActiviItemType")->middleware('admin');
//查询活动表的事件
Route::post("admin/getacticityfilters","Admin\GetActicityFilters")->middleware('admin');

//给用户添加代金券
Route::post("admin/adduseractivity","Admin\AddUserActivity")->middleware('admin');
Route::post("admin/activityconfirm","Admin\UserActivityConfirm")->middleware('admin');
Route::post("admin/getuseractivitylist","Admin\GetUserActivityList")->middleware('admin');
//查询活动配置列表
Route::post("admin/getactivityconfiglist","Admin\GetActivityConfigList")->middleware('admin');
//查询用户邀请码列表
Route::post("admin/getuserinvitationcode","Admin\GetUserInvitationCode")->middleware('admin');
//添加用户邀请码
Route::post("admin/addinvitationcode","Admin\AddUserInvitationCode")->middleware('admin');
//删除活动配置
Route::post("admin/delactivityconfig","Admin\DeleteActivityConfig")->middleware('admin');
//删除用户邀请码
Route::post("admin/delinvitationcode","Admin\DeleteUserInvitationCode")->middleware('admin');
//查询活动配置详细
Route::post("admin/getactivityconfiginfo","Admin\GetActivityConfigInfo")->middleware('admin');
//查询用户邀请码详细
Route::post("admin/getuserinvitationcodeinfo","Admin\GetInvitationCodeInfo")->middleware('admin');
//修改活动配置
Route::post("admin/saveactivityconfig","Admin\SaveActivityConfig")->middleware('admin');
//修改用户邀请码
Route::post("admin/saveinvitationcode","Admin\SaveInvitationCode")->middleware('admin');
//添加活动配置
Route::post("admin/addactivityconfig","Admin\AddActivityConfig")->middleware('admin');

Route::post("admin/activity/activitylist","Admin\GetActivityList")->middleware('admin');
Route::post("admin/activity/voucherlist","Admin\GetVoucherList")->middleware('admin');

//添加活动
Route::post("admin/activity/addgroup","Admin\AddActivityGroup")->middleware('admin');

//添加邀请码
Route::post("admin/activity/addinvitationcode","Admin\AddActivityInvitationCode")->middleware('admin');



/*************************    查询用户信息   ***********************************/
//查询用户流水
Route::post("cash/getusercashjournal","User\GetUserCashJournalInfo")->middleware('login');
Route::post("cash/getusercashjournallist","User\GetUserCashJournalList")->middleware('login');
//查询用户现金余额
Route::post("user/getusercashaccount","User\GetUserCashAccountInfo")->middleware('login');
//用户添加银行卡
Route::post("user/addbankcard","User\AddUserBank")->middleware('login');
//查询用户银行卡
Route::post("user/getbankcards","User\GetUserBankCardList")->middleware('login');
//查询系统银行卡
Route::post("sys/getsysbankaccount","Sys\ListCashBankAccount");
//用户查询代币列表
Route::post("user/getusercoinlist","User\GetUserCoinList")->middleware('login');
//用户查询代币流水
Route::post("user/getcoinjournallist","User\GetCoinJournalList")->middleware('login');
//用户查询交易记录
Route::post("user/gettranactionorder","User\GetTranactionOrderList")->middleware('login');
Route::post("user/gettranactionorderinfo","User\GetTranactionOrderInfo")->middleware('login');
//用户查询可用现金券
Route::post("user/getstorage","User\GetVoucherStorage")->middleware('login');
//买单时查询是否可用券
Route::post("user/getvoucherinfo","User\GetVoucherInfo")->middleware('login');
Route::post("user/getcashcoinvoucher","User\GetCashCoinVoucher")->middleware('login');

//购买产品时获取现金券
Route::post("user/buyproductvoucher","User\GetBuyProductVoucher")->middleware('login');


//查询消息列表
Route::post("user/getmessagelist","User\GetMessageList")->middleware('login');

//修改消息为已读
Route::post("user/savemsgread","User\SaveMessageRead")->middleware('login');
//删除消息
Route::post("user/delmsg","User\DeleteMessage")->middleware('login');
//删除用户所有消息
Route::post("user/delusermsg","User\DeleteUserMessage")->middleware('login');
//查询用户未读消息数量
Route::post("user/getmsgcount","User\GetMessageCount")->middleware('login');


//查询现金交易记录
Route::post("user/getuserorder","User\GetCashOrder")->middleware('login');

//查询现金交易记录详细
Route::post("user/getuserorderinfo","User\GetCashOrderInfo")->middleware('login');

//查询现金交易记录详细
Route::post("user/getcoinscount","User\GetCoinsCount")->middleware('login');

//查询用户房产估值
Route::post("user/getassetCount","User\GetAssetCount")->middleware('login');

//查询用户现金提现费率
Route::post("user/get/cashwithdrawalfeerate","Cash\CashWithdrawalFeeRate")->middleware('login');

//查询用户资产情况
Route::post("user/get/getusertreature","User\GetTreatureInfo")->middleware('login');

//用户查询邀请情况
Route::post("user/get/getuserinvstatusinfo","User\GetUserInvStatusInfo")->middleware('login');

//用户查询当日邀请情况
Route::post("user/get/getuserinvstatusdayinfo","User\GetUserInvStatusDayInfo")->middleware('login');

//查询所有用户账户余额
Route::post("day/getusercashaccountlist","User\GetUserCashAccountDayList");

/*************************    查询管理员信息   ***********************************/

//查询手续费
Route::post("cash/getsyscashfeelist","Admin\GetSysCashFeeList")->middleware('admin');
Route::post("cash/getsyscashfeeinfo","Admin\GetSysCashFeeInfo")->middleware('admin');

//查询平台流水
Route::post("cash/getsyscashjournal","Admin\GetSysCashJournalInfo")->middleware('admin');
Route::post("cash/getsyscashjournallist","Admin\GetSysCashJournalList")->middleware('admin');
//查询资金池流水
Route::post("cash/getcashjournal","Admin\GetCashJournalInfo")->middleware('admin');
Route::post("cash/getcashjournallist","Admin\GetCashJournalList")->middleware('admin');

//查询平台余额
Route::post("cash/getsyscashaccount","Admin\GetSysCashAccountInfo")->middleware('admin');
//查询资金池余额
Route::post("cash/getcash","Admin\GetSysCashInfo")->middleware('admin');

//查询所有用户
Route::post("admin/getuserlist","Admin\GetUserList")->middleware('admin');

//查询所有项目
Route::post("admin/getitemlist","Admin\GetItemList")->middleware('admin');

//查询所有用户代币流水
Route::post("admin/getusercoinjournal","Admin\GetCoinJournal")->middleware('admin');

//查询所有邀请码
Route::post("admin/getinvitationcodes","Admin\GetInvitionCodes")->middleware('admin');

//查询邀请概况
Route::post("admin/getinvstatuslist","Admin\GetInvStatusList")->middleware('admin');

//对帐 

Route::post("admin/settlement/cash","Admin\GetSettlementCashList")->middleware('admin');
Route::post("admin/settlement/syscash","Admin\GetSettlementSysCashList")->middleware('admin');
Route::post("admin/settlement/usercash","Admin\GetSettlementUserCashList")->middleware('admin');

/****************  验证码****************/
//发送验证码接口
Route::post("sms/sendcode","Sys\SendSms")->middleware('token')->middleware('imgverify');

//邮件发送验证码接口
Route::post("email/sendcode","Kyc\SendEmail")->middleware('token');

//验证验证码接口
Route::post("sms/isverify","Sys\SmsCode")->middleware('token');

//验证邀请码
Route::post("auth/checkregcode","Auth\IsPhone")->middleware('token');

//查询邀请码信息
Route::post("user/getcodeinfo","User\RegProfile")->middleware('token');

//验证登陆密码和支付密码是否一致
Route::post("auth/paypwd","Auth\Paypwd")->middleware('token');

/****************  公告  ****************/
//管理员添加公告
Route::post("admin/addnews","Admin\AddSysNews")->middleware('admin');
Route::post("admin/getnewslist","Admin\GetSysNewsList")->middleware('admin');
//查询公告详情
Route::post("admin/getnewsinfo","News\GetSysNewsInfo")->middleware('admin');
//查询所有公告
Route::post("user/getnewslist","News\GetSysNewsList")->middleware('token');
//管理员修改公告
Route::post("admin/savenews","Admin\SaveNews")->middleware('admin');

//查询公告详情
Route::post("user/getnewsinfo","News\GetSysNewsInfo")->middleware('token');

//首页查询三个公告
Route::post("user/gethomenews","User\GetHomeNews")->middleware('token');






/*************************    查询项目   ***********************************/
//查询项目信息
Route::post("item/getinfo","Item\GetItemInfo")->middleware('token');
//查询房产信息
Route::post("item/gethouseinfo","Item\GetItemHouse")->middleware('token');
//查询投资分析信息
Route::post("item/getinvestinfo","Item\GetItemInvest")->middleware('token');
//查询同小区交易记录
Route::post("item/getitemsub","Item\GetItemSub")->middleware('token');
//查询同小区交易记录
Route::post("item/getitemorder","Item\GetItemOrder")->middleware('token');
//查询热销资产
Route::post("item/getheatitem","Item\GetHeatItem")->middleware('token');
//查询证照公式
Route::post("item/getfromula","Item\GetFromula")->middleware('token');
//查询项目图片
Route::post("item/getitemimage","Item\GetItemImage")->middleware('token');



/***********************/
Route::post("admin/dic/banks","Dic\Banks")->middleware('admin');
Route::post("admin/dic/buysatus","Dic\BuyStatus")->middleware('admin');
Route::post("admin/dic/sellstatus","Dic\SellStatus")->middleware('admin');
Route::post("admin/dic/newstype","Dic\News")->middleware('admin');
Route::post("admin/dic/pushtye","Dic\NewsPush")->middleware('admin');


/****************  其他****************/

Route::post("test","Test");
        
//字典
Route::post("dic/getbanks","Dic\Banks")->middleware('token');
Route::post("dic/getbuysatus","Dic\BuyStatus")->middleware('token');
Route::post("dic/getsellstatus","Dic\SellStatus")->middleware('token');
//根据类型查询
Route::post("admin/getdic","Admin\GetDictionary")->middleware('admin');
//根据类型查询
Route::post("dic/getdic","Admin\GetDictionary")->middleware('token');
//查询全部
Route::post("admin/getdiclist","Admin\GetDictionaryList")->middleware('admin');
//查询详细
Route::post("admin/getdicinfo","Admin\GetDictionaryInfo")->middleware('admin');
//添加字典表
Route::post("admin/adddic","Admin\AddDictionary")->middleware('admin');
//删除字典表
Route::post("admin/deldic","Admin\DeleteDictionary")->middleware('admin');
//修改字典表
Route::post("admin/savedic","Admin\SaveDictionary")->middleware('admin');




//查询公告类型
Route::post("dic/getnewspushtype","Admin\GetNewsPushType")->middleware('login');
//查询公告推送类型
Route::post("dic/getnewstype","Admin\GetNewsType")->middleware('login');


//自动对帐相关

Route::post("settlement/cash/day","Settlement\MakeDayCashSettlement")->middleware('token');
Route::post("settlement/cash/hour","Settlement\MakeHourCashSettlement")->middleware('token');

Route::post("settlement/syscash/day","Settlement\MakeDaySysCashSettlement")->middleware('token');
Route::post("settlement/syscash/hour","Settlement\MakeHourSysCashSettlement")->middleware('token');


Route::post("settlement/usercash/day","Settlement\MakeDayUserCashSettlement")->middleware('token');
Route::post("settlement/usercash/hour","Settlement\MakeHourUserCashSettlement")->middleware('token');
//查询所有用户
Route::post("settlement/getuserlist","Admin\GetUserList")->middleware('admin');


//查询平台余额
Route::post("settlement/getsyscashaccount","Admin\GetSysCashAccountInfo")->middleware('token');
//查询资金池余额
Route::post("settlement/getcash","Admin\GetSysCashInfo")->middleware('token');



Route::post("user/getcashbanklist","User\GetCashBankList")->middleware('login');
Route::post("admin/getcashbanklist","User\GetCashBankList")->middleware('admin');
Route::post("user/deletecashbank","User\DeleteUserBankAccount")->middleware('login')->middleware('chkpaypwd');


/********************************     产品     ******************************/
//新建产品
Route::post("product/addproductinfo","Product\AddProduct")->middleware('login')->middleware('chkpaypwd');
//查询产品列表
Route::post("product/getproductinfolist","Product\GetProductInfoList")->middleware('token');
//查询用户产品列表
Route::post("product/getuserproductinfolist","Product\GetUserProductInfoList")->middleware('login');
//查询用户产品列表
Route::post("product/getadminproductinfolist","Product\GetAdminProductInfoList")->middleware('admin');
//购买产品
Route::post("product/buyproduct","Product\BuyProduct")->middleware('login')->middleware('chkstatus')->middleware('chkidno')->middleware('chkpaypwd')->middleware('checkaccount');
//添加产品价格
Route::post("product/addtrend","Product\AddTrend")->middleware('admin');
//查询产品价格详细
Route::post("product/gettrendinfo","Product\GetTrendInfo")->middleware('admin');
//修改产品价格
Route::post("product/savetrend","Product\SaveTrend")->middleware('admin');
//删除产品价格
Route::post("product/deletetrend","Product\DeleteTrend")->middleware('admin');
//查询产品价格列表
Route::post("product/gettrendlist","Product\GetTrendList")->middleware('admin');



/*************************        微信相关接口       ***********************************/
/*********************************   微信相关      ************************************/

//绑定
Route::post("wechat/appbind","Wechat\AppBind")->middleware('token');

//登陆
Route::post("wechat/applogin","Wechat\AppLogin")->middleware('token')->middleware('chkmobileverify');

//注册
Route::post("wechat/appreg","Wechat\AppReg")->middleware('token')->middleware('chkmobileverify')->middleware('chkinvitationcode');

//微信注册 不输入登录密码
Route::post("wechat/regnopwd","Wechat\WechatRegNoPwd")->middleware('token')->middleware('chkmobileverify')->middleware('chkinvitationcode');


//微信注册
Route::post("wechat/reg","Wechat\WechatReg")->middleware('token')->middleware('chkinvitationcode');

//查询用户信息
Route::post("wechat/getuserinfo","Wechat\GetUserInfo")->middleware('token');
//查询用户充值详细
Route::post("wechat/getrechargeinfo","Wechat\GetRechargeInfo")->middleware('login');
//查询用户提现详细
Route::post("wechat/getwithdrawalinfo","Wechat\GetWithdrawalInfo")->middleware('login');
//查询用户交易详细
Route::post("wechat/getorderinfo","Wechat\GetOrderInfo")->middleware('login');
//查询用户现金券详细
Route::post("wechat/getvoucherinfo","Wechat\GetVoucherInfo")->middleware('login');

//验证码登陆
Route::post("auth/mobilelogin","Auth\MobileLogin")->middleware('token')->middleware('chkmobileverify');

//判断支付密码是否为空
Route::post("user/paypwdisempty","User\PayPwdIsEmpty")->middleware('login');

//初始化支付密码
Route::post("user/adduserpaypwd","User\AddUserPayPwd")->middleware('login');

//获取登陆验证码
Route::post("auth/getcode","Auth\GetCode")->middleware('token');

//判断身份证是否匹配
Route::post("auth/checkidno","Auth\CheckIdno")->middleware('login');

//更新用户信息
Route::post("user/storageinfo","User\StorageInfo")->middleware('login');

//初始化身份证信息
Route::post("user/adduseridno","User\AddUserIdno")->middleware('login');

//微信登陆并且注册
Route::post("wechat/loginreg","Wechat\LoginReg")->middleware('token')->middleware('chkmobileverify')->middleware('chkinvitationcode');




/****************************** 银行卡 *******************************************/

//用户查询银行卡列表
Route::post("bank/getuserbanklist","Bank\GetUserBankList")->middleware('login');

//用户查询银行列表
Route::post("bank/getuserbanks","Bank\GetUserBanks")->middleware('login');

//管理员添加银行
Route::post("bank/addbank","Bank\AddBank")->middleware('admin');

//管理员审核银行
Route::post("bank/checkbank","Bank\CheckBank")->middleware('admin');

//管理员查询银行卡列表
Route::post("bank/getadminbanklist","Bank\GetAdminBankList")->middleware('admin');


/************************** 现金券 ******************************/

//用户兑换现金券
Route::post("user/adduservoucher","User\AddUserVoucher")->middleware('login')->middleware('chkinvitationcode');




/************************************ VP管理  ******************************************/
//撤消产品
Route::post("product/revokeproduct","Product\RevekeProduct")->middleware('login');

//查询是否是vp
Route::post("product/getvpproduct","Product\GetVpProduct")->middleware('login');













/**** 第三方支付 ***/
// 发起第三方支付
Route::post("3rdpay/gateway","ThirdPayment\RequirePayment")->middleware("login")->middleware('chkidno');
Route::post("3rdpay/methods","ThirdPayment\GetPayMethods")->middleware("login");
Route::post("3rdpay/prepare","ThirdPayment\PrepareJsPay")->middleware("login")->middleware('chkidno');
Route::post("3rdpay/recharge","ThirdPayment\PrepareJsRecharge")->middleware("login")->middleware('chkidno');
Route::post("3rdpay/confirm/","ThirdPayment\ConfirmPayment");

Route::post("3rdpay/confirm/{m}","ThirdPayment\ConfirmPayment");


Route::post("3rdpay/confirmjs/","ThirdPayment\ComfirmJsPayment");

Route::post("3rdpay/confirmjs/{m}","ThirdPayment\ComfirmJsPayment");



//管理员查询通道列表
Route::post("admin/get/channels","Admin\GetPayChannels")->middleware("admin");

//管理员查询支付列表
Route::post("admin/get/pays","Admin\GetPays")->middleware("admin");

//管理员查询入账列表
Route::post("admin/get/payincomeds","Admin\GetPayIncomeds")->middleware("admin");

/********************* 返佣 **********************/

//返佣报表
Route::post("report/getuserrbreportdaylist","Report\GetUserrbReportDayList")->middleware("login");
Route::post("user/getuserrbreportdayinfo","User\GetUserrbReportDayInfo")->middleware("login");

//返佣排行
Route::post("user/getuserrbrank","User\GetUserrbRank")->middleware("login");

//获取当前返佣金额
Route::post("report/getuserrbreport","Report\GetUserrbReport")->middleware("admin");



//查询买单列表
Route::post("token/trade/getbuys","Trade\GetTransactionBuys");

//查询卖单列表
Route::post("token/trade/getsells","Trade\GetTransactionSells");

//查询买单卖单列表
Route::post("token/trade/gettransactions","Trade\GetTransactions");