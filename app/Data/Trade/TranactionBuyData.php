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

class TranactionBuyData extends IDatafactory //implements INotifyDefault
{
    protected $modelclass = 'App\Model\Trade\TranactionBuy';

    protected $no = 'buy_no';

    const LEVEL_TYPE_PRODUCT = 'BL01';
    const LEVEL_TYPE_MARKET = 'BL00';

    /**
     * 执行挂买单操作
     *
     * @param   $count 买的数量
     * @param   $price 价格
     * @param   $coin 币种
     * @param   $docMd5 md5类
     * @param   $userCashJournalNo 用户现金流水表单据号
     * @param   $transactionBuyNo 买单单据号
     * @author  zhoutao
     * @version 0.1
     */
    public function addBuy($count, $price, $coin, $transactionBuyNo, $coinaccount, $region)
    {
        $amount = $count * $price;
        $transactionBuyRate = config("trans.ordercoinfeerate");
        //写入买单表
        $transactionBuyModel = $this->newitem();
        $transactionBuyModel->buy_no = $transactionBuyNo;
        $transactionBuyModel->buy_count = $count;
        $transactionBuyModel->buy_limit = $price;
        $transactionBuyModel->buy_feerate = $transactionBuyRate;
        $transactionBuyModel->buy_ammount = $amount;
        $transactionBuyModel->buy_userid = $this->session->userid;
        $transactionBuyModel->buy_cointype = $coin;
        $transactionBuyModel->buy_status = 'TB00';
        $transactionBuyModel->buy_usercointaccount = $coinaccount;
        $transactionBuyModel->buy_region = $region;
        return $transactionBuyModel->save();
    }

    /**
     * 增加了显示数量、价格，比例因子
     *
     * @param   $toUserSHowCount 显示数量
     * @param   $toUserShowPrice 显示价格
     * @param   $scale 比例因子
     * @param   $feePrice 带手续费的显示价格
     * @param   $feeCount 带手续费的显示数量
     * @author  zhoutao
     * @version 0.2
     *
     * 挂买单
     * @param   $count 数量
     * @param   $price 单价
     * @param   $coin 代币类型
     * @param   $transactionBuyNo 买单号
     * @param   $coinaccount 代币账户id
     * @param   $region 地区
     * @param   $feeType 代币手续费类型
     * @param   $cashFeeRate 现金手续费率
     * @param   $cashFeeType 现金手续费类型
     * @param   $cashFeeHidden 现金手续费是否可见
     * @param   $coinFeeHidden 代币手续费是否可见
     * @param   $feeRate 代币手续费率
     * @param   $buyShowCount 显示数量
     * @param   $buyShowPrice 显示价格
     * @param   $buyCashFee 现金手续费
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.17
     * 
     * @param  $buyLevelType 买单类型 BL00 普通 BL01 一级
     * @author zhoutao
     * @date   2017.8.24
     */
    public function add($count, $price, $coin, $transactionBuyNo, $coinaccount, $region, $feeRate, $feeType, $cashFeeRate, $cashFeeType, $cashFeeHidden, $coinFeeHidden, $buyShowCount, $buyShowPrice, $buyCashFee, $toUserShowPrice, $toUserSHowCount, $scale, $feePrice, $feeCount, $buyLevelType = self::LEVEL_TYPE_PRODUCT)
    {
        $amount = $count * $price;
        //写入买单表
        $transactionBuyModel = $this->newitem();
        $transactionBuyModel->buy_no = $transactionBuyNo;
        $transactionBuyModel->buy_count = $count;
        $transactionBuyModel->buy_limit = $price;
        $transactionBuyModel->buy_feerate = $feeRate;
        $transactionBuyModel->buy_ammount = $amount;
        $transactionBuyModel->buy_userid = $this->session->userid;
        $transactionBuyModel->buy_cointype = $coin;
        $transactionBuyModel->buy_status = 'TB00';
        $transactionBuyModel->buy_usercointaccount = $coinaccount;
        $transactionBuyModel->buy_region = $region;
        $transactionBuyModel->buy_feetype = $feeType;
        $transactionBuyModel->buy_cashfeerate = $cashFeeRate;
        $transactionBuyModel->buy_cashfeetype = $cashFeeType;
        $transactionBuyModel->buy_cashfeehidden = $cashFeeHidden;
        $transactionBuyModel->buy_coinfeehidden = $coinFeeHidden;
        $transactionBuyModel->buy_showcount = $buyShowCount;
        $transactionBuyModel->buy_showprice = $buyShowPrice;
        $transactionBuyModel->buy_cashfee = $buyCashFee;
        $transactionBuyModel->buy_touser_showprice = $toUserShowPrice;
        $transactionBuyModel->buy_touser_showcount = $toUserSHowCount;
        $transactionBuyModel->buy_scale = $scale;
        $transactionBuyModel->buy_touser_feeprice = $feePrice;
        $transactionBuyModel->buy_touser_feecount = $feeCount;
        $transactionBuyModel->buy_leveltype = $buyLevelType;
        return $transactionBuyModel->save();
    }

    /**
     * 更新买单表
     *
     * @param   $transactionBuyNo 买单单据号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveBuy($transactionBuyNo)
    {
        $where['buy_no'] = $transactionBuyNo;
        $where['buy_userid'] = $this->session->userid;
        $model = $this->findForUpdate($where);
        //挂单数量
        $transactionBuyCount = $model->buy_transcount;
        $transactionCount = $model->buy_count;
        $transactionPrice = $model->buy_limit;
        //计算金额 = （挂单数量 - 成交数量） * 单价
        $res['amount'] = ($transactionCount - $transactionBuyCount) * $transactionPrice;
        //更新买单表状态
        $status = 'TB04'; //默认为全部撤销
        if ($transactionBuyCount > 0) {
            //如果有成交 则改为部分撤销
            $status = 'TB03';
        }
        $model->buy_status = $status;
        $res['res'] = $model->save();
        return $res;
    }

    /**
     * 获取买单类型
     *
     * @param   $buyNo 买单单据号
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getLevelType($buyNo)
    {
        $model=$this->newitem();
        $res=$model->where('buy_no', $buyNo)->first();  
        if(!$res) {
            return null;
        }
        return $res->buy_leveltype;
    }
         
    
    // public function notifycreateddefaultrun($data)
    // {
    //     //   $tranactionOrderData=new TranactionOrderData();
    //     //   $tranactionOrderData->buySellOrder($data['buy_no'],$data['created_at']);
    //       return true;
    // }

    // public function notifysaveddefaultrun($data)
    // {
          
    // }

    // public function notifydeleteddefaultrun($data)
    // {
          
    // }
}
