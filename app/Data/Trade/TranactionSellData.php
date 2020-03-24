<?php
namespace App\Data\Trade;

use App\Data\Sys\CoinJournalData;
use App\Model\User\User;
use App\Data\IDataFactory;
use App\Http\Adapter\Trade\TranactionSellAdapter;
use App\Http\Adapter\User\CoinAccountAdapter;
use App\Data\User\CoinAccountData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Data\User\UserTypeData;
use App\Data\Utils\Formater;
use App\Data\Notify\INotifyDefault;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\UserData;
use App\Data\Project\ProjectGuidingPriceData;

class TranactionSellData extends IDatafactory //implements INotifyDefault
{
    protected $modelclass = 'App\Model\Trade\TranactionSell';

    protected $no = 'sell_no';

    const NEW_SELL_STATUS = 'TS00';
    const PARTIAL_TRANSACTION_STATUS = 'TS01';
    const SUCCESS_STATUS = 'TS02';
    const REVOKE_ALL_STATUS = 'TS04';

    const LEVEL_TYPE_PRODUCT = 'SL01';
    const LEVEL_TYPE_MARKET = 'SL00';

    const SELL_USER_NAME = '咔咔买房';

    private $tags = [
        '理财金专享',
        '活动专享',
        '90天后可交易',
    ];

    /**
     * 增加啦leveltype 参数判断是否一级市场
     *
     * @param   $levelType 类型
     * @author  zhoutao
     * @version 0.2
     * @date    2017.3.24
     * 挂卖单操作
     * @param   $count 卖数量
     * @param   $price 价格
     * @param   $coin 币种
     * @param   $userCoinJournalNo 用户代币流水表单据号
     * @param   $transactionSellNo 卖单单据号
     * @author  zhoutao
     * @version 0.1
     */
    public function addSell($count, $price, $coin, $transactionSellNo, $usercoinaccount, $region, $levelType)
    {
        $transactionBuyRate = config("trans.withdrawalfeerate");
        $amount = $count * $price;
        $model = $this->newitem();
        $model->sell_no = $transactionSellNo;
        $model->sell_count = $count;
        $model->sell_limit = $price;
        $model->sell_feerate = $transactionBuyRate;
        $model->sell_ammount = $amount;
        $model->sell_userid = $this->session->userid;
        $model->sell_usercointaccount = $usercoinaccount;
        $model->sell_cointype = $coin;
        $model->sell_status = 'TS00';
        $model->sell_leveltype = $levelType;
        $model->sell_region = $region;
        return $this->create($model);
    }

    /**
     * 增加了显示数量，价格，比例因子的参数
     *
     * @param   $toUserShowCount 显示数量
     * @param   $toUserShowPrice 显示价格
     * @param   $scale 比例因子
     * @param   $feePrice 带手续费显示价格
     * @param   $feeCount 带手续费显示数量
     * @author  zhoutao
     * @version 0.2
     *
     * 修改后添加卖单
     * @param   $count 数量
     * @param   $price 单价
     * @param   $coin 代币类型
     * @param   $transactionSellNo 卖单号
     * @param   $usercoinaccount 用户代币账户
     * @param   $region 地区
     * @param   $levelType 一级市场
     * @param   $feeType 现金手续费类型
     * @param   $coinFeeRate 代币手续费率
     * @param   $coinFeeType 代币手续费类型
     * @param   $cashFeeRate 现金手续费率
     * @param   $cashFeeHidden 现金手续费是否可见
     * @param   $coinFeeHidden 代币手续费是否可见
     * @param   $showCoinPrice 显示单价
     * @param   $showCoinCount 显示数量
     * @param   $sellCoinFee 代币手续费
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.17
     */
    public function add($count, $price, $coin, $transactionSellNo, $usercoinaccount, $region, $levelType, $feeType, $coinFeeRate, $coinFeeType, $cashFeeRate, $cashFeeHidden, $coinFeeHidden, $showCoinCount, $showCoinPrice, $sellCoinFee, $toUserShowPrice, $toUserShowCount, $scale, $feePrice, $feeCount)
    {
        $amount = $count * $price;
        $model = $this->newitem();
        $model->sell_no = $transactionSellNo;
        $model->sell_count = $count;
        $model->sell_limit = $price;
        $model->sell_feerate = $cashFeeRate;
        $model->sell_ammount = $amount;
        $model->sell_userid = $this->session->userid;
        $model->sell_usercointaccount = $usercoinaccount;
        $model->sell_cointype = $coin;
        $model->sell_status = 'TS00';
        $model->sell_leveltype = $levelType;
        $model->sell_region = $region;
        $model->sell_feetype = $feeType;
        $model->sell_coinfeerate = $coinFeeRate;
        $model->sell_coinfeetype = $coinFeeType;
        $model->sell_cashfeehidden = $cashFeeHidden;
        $model->sell_coinfeehidden = $coinFeeHidden;
        $model->sell_showcoinprice = $showCoinPrice;
        $model->sell_showcoincount = $showCoinCount;
        $model->sell_coinfee = $sellCoinFee;
        $model->sell_touser_showprice = $toUserShowPrice;
        $model->sell_touser_showcount = $toUserShowCount;
        $model->sell_scale = $scale;
        $model->sell_touser_feeprice = $feePrice;
        $model->sell_touser_feecount = $feeCount;
        return $this->create($model);
    }

    /**
     * 撤销卖单时候更新卖单表操作
     *
     * @param   $transactionSellNo 卖单单据号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function saveSell($transactionSellNo,$userid = null)
    {
        if (empty($userid)) {
            $userid = $this->session->userid;
        }
        $where['sell_no'] = $transactionSellNo;
        $where['sell_userid'] = $userid;
        $model = $this->findForUpdate($where);
        //挂单数量
        $transactionSellCount = $model->sell_transcount;
        $transactionCount = $model->sell_count;
        $res['coinType'] = $model->sell_cointype;
        //计算金额 = （挂单数量 - 成交数量） * 单价
        $res['amount'] = $transactionCount - $transactionSellCount;
        //更新买单表状态
        $status = 'TS04'; //默认为全部撤销
        if ($transactionSellCount > 0) {
            //如果有成交 则改为部分撤销
            $status = 'TS03';
        }
        $model->sell_status = $status;
        $res['res'] = $model->save();
        return $res;
    }

    /**
     * 查询卖单是否可用代金券
     *
     * @param   $no 卖单号
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function isVoucher($no)
    {
        $info = $this->getByNo($no);
        if ($info->sell_leveltype === 'SL00') {
            return false;
        }
        return true;
    }

    /**
     * 查询卖单
     *
     * @param   $no 单据号
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getInfo($no)
    {
        $where['sell_no'] = $no;
        return $this->find($where);
    }

    /**
     * 查找单价和代币类型
     *
     * @param   $no 单据号
     * @return  mixed
     * @author  zhoutao
     * @version 0,1
     */
    public function getCoin($no)
    {
        $info = $this->getInfo($no);
        $res['price'] = $info->sell_limit;
        $res['coinType'] = $info->sell_cointype;
        $res['count'] = $info->sell_count - $info->sell_transcount;
        return $res;
    }

    /**
     * 查询单价和代币类型
     *
     * @param   $no
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.19
     * 
     * 增加返回份数和份的单价
     * @author  zhoutao
     * @date    2017.10.20
     * 
     * 增加返回比例因子
     * @author  zhoutao
     * @date    2017.10.30
     */
    public function getSellInfo($no)
    {
        $info = $this->getInfo($no);
        if ($info == null) {
            $res['price'] = 0;
            $res['coinType'] = '';
            $res['count'] = 0;
            $res['levelType'] = '';
            $res['toUserPrice'] = 0;
            $res['toUserPrice'] = 0;
            $res['scale'] = 0;
            return $res;
        }
        $res['price'] = $info->sell_showcoinprice;
        $res['coinType'] = $info->sell_cointype;
        $res['count'] = $info->sell_count - $info->sell_transcount;
        $res['levelType'] = $info->sell_leveltype;
        $res['toUserPrice'] = $info->sell_touser_showprice;
        $res['toUserCount'] = $info->sell_touser_showcount;
        $res['scale'] = $info->sell_scale;
        return $res;
    }

    /**
     * 查询显示价格和数量和代币类型
     *
     * @param   $no
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.19
     */
    public function getShowSell($no)
    {
        $info = $this->getInfo($no);
        $res = [];
        if ($info == null) {
            $res = array_add($res, 'price', 0);
            $res = array_add($res, 'coinType', '');
            $res = array_add($res, 'count', 0);
            $res = array_add($res, 'surplusCount', 0);
            return $res;
        }
        $res = array_add($res, 'price', $info->sell_touser_feeprice);
        $res = array_add($res, 'coinType', $info->sell_cointype);
        $productSurplusCount = $info->sell_touser_feecount - ($info->sell_transcount / $info->sell_scale);
        $res = array_add($res, 'count', $info->sell_touser_feecount - $info->sell_transcount);
        $res = array_add($res, 'surplusCount', $productSurplusCount);
        return $res;
    }

    /**
     * 修正啦orwhere 改为啦whereIn
     *
     * @author  zhoutao
     * @version 0.3
     * @date    2017.3.24
     *
     * 增加啦userid
     * @author  zhoutao
     * @version 0.2
     * @date    2017.3.23
     *
     * 查找卖单列表
     * @param   $pageSize
     * @param   $pageIndex
     * @return  mixed
     * @author  zhoutao
     * @version 0.1
     */
    public function getSellList($pageSize, $pageIndex, $order, $filter, $userid = null)
    {

        $orderArray = ['asc','desc'];
        $model = $this->newitem();
        $res = [];
        $tmp = null;
        $tmp = $model->whereIn('sell_status', ['TS00','TS01']);
        if ($userid != null) {
            $tmp = $tmp->where('sell_userid', $userid);
        }
        if (is_array($filter)) {
            foreach ($filter as $col => $val) {
                if (!in_array($val, $orderArray)) {
                    $tmp = $tmp->where($col, $val);
                }
            }
        }
        $res['totalSize'] = $tmp->count();

        //        if (is_array($order)) {
        //            foreach ($order as $k => $v) {
        //                if (!is_array($v) && in_array($v,$orderArray)) {
        //                    if ($tmp == null) {
        //                        $tmp = $model->orderBy($k,$v);
        //                    } else {
        //                        $tmp = $tmp->orderBy($k,$v);
        //                    }
        //                }
        //            }
        //        }

        $res['items'] = $tmp->orderBy('created_at', 'desc')->offset($pageSize*($pageIndex-1))->limit($pageSize)->get();
        $res["pageIndex"]=$pageIndex;
        $res["pageSize"]=$pageSize;
        $res["pageCount"]= ($res['totalSize']-$res['totalSize']%$res["pageSize"])/$res["pageSize"] +($res['totalSize']%$res["pageSize"]===0?0:1);
        return $res;
    }

    public function getSellOrder($pageSize, $pageIndex, $filter)
    {
        $orderArray = ['asc','desc'];
        $model = $this->newitem();
        $res = [];
        $tmp = null;
        $tmp = $model->whereIn('sell_status', ['TS00','TS01']);
        //        if (is_array($filter)) {
        //            foreach ($filter as $col=>$val) {
        //                if (!in_array($val,$orderArray)) {
        //                    $tmp = $tmp->where($col,$val);
        //                }
        //            }
        //        }
        $res['totalSize'] = $model->whereIn('sell_status', ['TS00','TS01','TS02'])->count();
        $items = $tmp->orderBy('sell_limit', 'asc')
            ->orderBy('sell_leveltype', 'desc')
            ->offset($pageSize*($pageIndex-1))
            ->limit($pageSize)
            ->get();
        $res['items'] = [];
        foreach ($items as $col => $val) {
            $res['items'][] = $val;
        }

        if (count($items->toArray()) < $pageSize) {
            $count = 15;
            $page =  ($pageIndex  - ($count - $count % $pageSize) / $pageSize)  -1;
            if ($page==0
            ) {
                $offset =0;
            } else {
                $offset =$page * $pageSize - ($count % $pageSize === 0  ?
                        0:($count % $pageSize)) ;
            }
            //            $offset = ($pageIndex - ($count - $count % $pageSize) / $pageSize - 1) * $pageSize + $count % $pageSize;
            $limit = $pageSize - count($items->toArray());
            $itemsTwo = $model->where('sell_status', 'TS02')
                ->orderBy('sell_limit', 'asc')
                ->orderBy('sell_leveltype', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
            foreach ($itemsTwo as $col => $val) {
                $res['items'][] = $val;
            }
        }

        $res["pageIndex"]=$pageIndex;
        $res["pageSize"]=$pageSize;
        $res["pageCount"]= ($res['totalSize']-$res['totalSize']%$res["pageSize"])/$res["pageSize"] +($res['totalSize']%$res["pageSize"]===0?0:1);
        return $res;
    }

    /**
     * 判断是否为一级市场
     *
     * @param   $sellNo 卖单号码
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function isPrimary($sellNo)
    {
        $coinInfo = $this->getByNo($sellNo);
        if ($coinInfo == null) {
            return false;
        }
        if ($coinInfo->sell_leveltype == 'SL00') {
            return false;
        }
        return true;
    }

    /**
     * 查询用户卖出的数量
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserCount()
    {
        $where['sell_userid'] = $this->session->userid;
        $model = $this->newitem();
        $status = ['TS00','TS01'];
        $count = $model->where($where)->whereIn('sell_status', $status)->count();
        return $count;
    }

    /**
     * 插销产品
     *
     * @param  $sellNo 卖单号
     * @author zhoutao
     * @date   2017.8.22
     */ 
    public function revokeProduct($sellNo)
    {
        $transactionSellData = new CoinSellData();
        $date = date('Y-m-d H:i:s');

        $transactionSellData->revokeSell($sellNo, $date);

        //查找卖单数量，如果没卖出，直接返回0
        $sellInfo = $this->getByNo($sellNo);
        if ($sellInfo->sell_status == TranactionSellData::REVOKE_ALL_STATUS && $sellInfo->sell_transcount == 0) {
            return 0;
        }

        //改卖单数量
        return $this->updateCount($sellNo);
    }


    public function updateCount($sellNo)
    {
        $userTypeData = new UserTypeData();
        $sysConfigKey = $userTypeData->getData($this->session->userid);

        $sellInfo = $this->getByNo($sellNo);
        $sellCoinCount = $sellInfo->sell_transcount;


        $sellCoinFeetype = $sellInfo->sell_coinfeetype;
        $sellCoinFeeRate = $sellInfo->sell_coinfeerate;
        //取出比例因子
        $showCoinScale = $sellInfo->sell_scale;
        switch ($sellCoinFeetype) {
        case CoinSellData::$SELL_FEE_TYPE_FREE:
            $sellCoinFee = 0;
            $sellCoinAmmount = $sellCoinCount;
            $showCoinCount = $sellCoinCount;
            break;
        case CoinSellData::$SELL_FEE_TYPE_IN:
            //价内
            $sellCoinFee = 0;
            $sellCoinAmmount = $sellCoinCount;
            $showCoinCount = $sellCoinCount;
            break;
        case CoinSellData::$SELL_FEE_TYPE_OUT:
            //价外
            $sellCoinFee = $sellCoinCount * $sellCoinFeeRate / (1 + $sellCoinFeeRate);
            $sellCoinAmmount = $sellCoinCount;
            $showCoinCount = $sellCoinCount * (1 + $sellCoinFeeRate);
            break;
        default:
            break;
        }

        //处理代币手续费
        $sellCoinFee = Formater::ceil($sellCoinFee);
        $feeCount = $showCoinCount / $showCoinScale;

        $sellInfo = $this->getByNo($sellNo);
        $sellInfo->sell_count = $showCoinCount;
        $sellInfo->sell_ammount = $sellInfo->sell_count * $sellInfo->sell_limit;
        $sellInfo->sell_showcoincount = $showCoinCount;
        $sellInfo->sell_coinfee = $sellCoinFee;
        $sellInfo->sell_touser_feecount = $feeCount;
        $sellInfo->sell_touser_showcount = $sellInfo->sell_transcount / $showCoinScale;
        $this->save($sellInfo);
        return $sellInfo->sell_touser_showcount / $showCoinScale;
    }

    /**
     * 获取卖单类型
     *
     * @param   $sellNo 卖单单据号
     * @return  mixed
     * @author  liu
     * @version 0.1
     */
    public function getTranscount($sellNo)
    {
        $model=$this->newitem();
        $res=$model->where('sell_no', $sellNo)->first();  
        return $res->sell_transcount;
    }

    // public function notifycreateddefaultrun($data)
    // {
    //     //   $tranactionOrderData=new TranactionOrderData();
    //     //   $tranactionOrderData->sellOrder($data['sell_no'],$data['created_at']);
    //       return true;
    // }

    // public function notifysaveddefaultrun($data)
    // {
    //       return true;
    // }

    // public function notifydeleteddefaultrun($data)
    // {
          
    // }

    /**
     * 获取卖单的最低价格
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.17
     */
    public function getCurrentPrice($coinType)
    {
        $model = $this->modelclass;
        $where['sell_cointype'] = $coinType;
        $info = $model::where($where)->whereIn('sell_status', [self::NEW_SELL_STATUS, self::PARTIAL_TRANSACTION_STATUS])->orderBy('sell_touser_showprice', 'asc')->first();
        $currentPrice = 0;
        if (!empty($info)) {
            $currentPrice = $info->sell_touser_showprice;
        }else {
            $info = $model::where($where)->whereIn('sell_status', [self::SUCCESS_STATUS])->orderBy('id','desc')->first();
            if(!empty($info) ){
                $currentPrice = $info->sell_touser_showprice; 
            }
    
        }
        return $currentPrice;
    }

    /**
     * 购买时候查询项目的所有卖单
     *
     * @param  $count 取多少条
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.19
     * 
     * 屏蔽剩余数量小于等于0的
     * @author zhoutao
     * @date   2017.10.22
     */
    public function getSells($count, $coinType)
    {
        $sellAdapter = new TranactionSellAdapter;
        $userCashBuyData = new UserCashBuyData;
        $userData = new UserData;
        $projectGuidingPriceData = new ProjectGuidingPriceData;
        $model = $this->modelclass;
        $res = [];
        $tmp = $model::whereIn('sell_status', [self::NEW_SELL_STATUS, self::PARTIAL_TRANSACTION_STATUS])
                        ->where('sell_cointype', $coinType);
        $lpInfo = $this->getLpFirst($coinType);

        if (!empty($lpInfo)) {
            $price = Formater::ceil($lpInfo->sell_touser_showprice);
            $where['sell_touser_showprice'] = $price;
            $where['sell_leveltype'] = self::LEVEL_TYPE_PRODUCT;
            $scale = $lpInfo->sell_scale;
            
            $lpCount = $tmp->where($where)->sum('sell_touser_showcount');
            $lpTransCount = $tmp->where($where)->sum('sell_transcount');
            $lpTransCount = $scale == 0 ? 0 : $lpTransCount / $scale;
            //查询买一级手续费
            $feeRates = $userCashBuyData->getFee($this->session->userid);
            if ($feeRates['buyCashFeetype'] == UserCashBuyData::$SELL_FEE_TYPE_FREE) {
                $feeRate = 0;
            } else {
                $feeRate = $feeRates['buyCashFeeRate'];
            }
            $lpCount = Formater::ceil($lpCount - $lpTransCount);
            if ($lpCount > 0) {
                $product['no'] = $lpInfo->sell_no;
                $product['count'] = $lpCount;
                $product['price'] = $price;
                $product['amount'] = $lpCount * $price;
                $product['name'] = self::SELL_USER_NAME;
                $product['tags'] = $this->tags;
                $product['feeRate'] = floatval($feeRate);
                $res[] = $product;
            }
            
        } else {
            $guidingPrice = $projectGuidingPriceData->getGuidingPrice($coinType);
            $product['no'] = 'no';
            $product['count'] = 0;
            $product['price'] = empty($guidingPrice) ? 0 :$guidingPrice->project_guidingprice;
            $product['amount'] = 0;
            $product['name'] = self::SELL_USER_NAME;
            $product['tags'] = $this->tags;
            $product['feeRate'] = 0;
            $res[] = $product;
        }

        $tmp = $model::whereIn('sell_status', [self::NEW_SELL_STATUS, self::PARTIAL_TRANSACTION_STATUS])
                        ->where('sell_cointype', $coinType);

        $markets = $tmp->where('sell_leveltype', self::LEVEL_TYPE_MARKET)
            ->orderBy('sell_touser_showprice', 'asc')
            ->limit($count)
            ->get();
        foreach ($markets as $market) {
            $sell = $sellAdapter->getDataContract($market);
            $no = $sell['no'];
            $userid = $sell['userid'];
            $count = Formater::ceil($sell['touserShowcount']);
            $price = Formater::ceil($sell['touserShowprice']);
            $transCount = Formater::ceil($sell['transcount']);
            $scale = $sell['scale'];
            $transCount = $scale == 0 ? 0 : $transCount / $scale;
            $count = Formater::ceil($count - $transCount);
            //查询买二级手续费
            $feeRates = $userCashBuyData->getMarketFee($this->session->userid);
            if ($feeRates['buyCashFeetype'] == UserCashBuyData::$SELL_FEE_TYPE_FREE) {
                $feeRate = 0;
            } else {
                $feeRate = $feeRates['buyCashFeeRate'];
            }
            $user = $userData->get($userid);
            $name = empty($user) ? '' : $user->user_name;
            if ($count > 0) {
                $arr['no'] = $no;
                $arr['count'] = $count;
                $arr['price'] = $price;
                $arr['amount'] = $count * $price;
                $arr['name'] = $name;
                $arr['tags'] = false;
                $arr['feeRate'] = floatval($feeRate);
                $res[] = $arr;
            }
        }
        return $res;
    }

    /**
     * 获取一级最低的挂单
     *
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.20
     */
    public function getLpFirst($coinType)
    {
        $model = $this->modelclass;
        $info = $model::whereIn('sell_status', [self::NEW_SELL_STATUS, self::PARTIAL_TRANSACTION_STATUS])
                ->where('sell_cointype', $coinType)
                ->where('sell_leveltype', self::LEVEL_TYPE_PRODUCT)
                ->orderBy('sell_touser_showprice', 'asc')
                ->orderBy('created_at', 'asc')
                ->first();
        return $info;
    }

    /**
     * 判断是不是价格最低的卖单 是返回true 不是false
     *
     * @param  $sellNo 卖单号
     * @author zhoutao
     * @date   2017.10.19
     * 
     * 增加代币类型
     * @param  $coinType 代币类型
     * @author zhoutao
     * @date   2017.10.21
     */
    public function isMinPrice($sellNo, $coinType)
    {
        $model = $this->modelclass;
        $where['sell_leveltype'] = self::LEVEL_TYPE_MARKET;
        $where['sell_cointype'] = $coinType;
        $sell = $model::whereIn('sell_status', [self::NEW_SELL_STATUS, self::PARTIAL_TRANSACTION_STATUS])
                ->where($where)
                ->orderBy('sell_touser_showprice', 'asc')
                ->first();
        if (empty($sell)) {
            return false;
        }
        if ($sell->sell_no != $sellNo) {
            return false;
        }
        return true;
    }
}
