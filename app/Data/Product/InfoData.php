<?php
namespace App\Data\Product;

use App\Data\IDataFactory;
use App\Data\Sys\ErrorData;
use App\Data\Trade\CoinSellData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Data\Trade\TranactionBuyData;
use App\Data\Trade\UserCashBuyData;
use App\Data\User\UserData;
use App\Data\User\UserTypeData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Product\InfoAdapter;
use App\Data\Project\ProjectInfoData;
use App\Http\Adapter\Item\InfoAdapter as ItemAdapter;
use App\Data\User\CoinAccountData;
use App\Data\Sys\LockData;
use Illuminate\Support\Facades\DB;
use App\Http\Adapter\Activity\VoucherInfoAdapter;
use App\Data\Activity\RegVoucherData;
use App\Data\Activity\VoucherStorageData;
use App\Http\Adapter\Activity\VoucherStorageAdapter;
use App\Data\Cash\UserRechargeData;
use App\Data\Product\TrendData;
use App\Http\Adapter\Product\TrendAdapter;
use App\Data\Item\CoordinateData;
use App\Http\Adapter\Item\CoordinateAdapter;
use App\Data\Item\ContractData;
use App\Http\Adapter\Project\ProjectInfoAdapter;

class InfoData extends IDatafactory
{

    protected $modelclass = 'App\Model\Product\Info';

    protected $no = 'product_no';

    public static $CASH_SELL_FEE_RATE = 'CASH_SELLFEERATE';
    public static $CASH_SELL_FEE_TYPE = 'CASH_SELLFEETYPE';
    public static $PRODUCT_FREEZETIME = 'PRODUCT_FREEZETIME';

    public static $SELL_FEE_TYPE_FREE = 'FR00';
    public static $SELL_FEE_TYPE_IN = 'FR01';
    public static $SELL_FEE_TYPE_OUT = 'FR02';

    public static $PRODUCT_STATUS_ONE = 'PRS01';
    public static $PRODUCT_NO_PREFIX = 'PRO';
    public static $USER_COIN_JOURNAL_NO_PREFIX = 'UOJ';
    public static $TRANS_SELL_NO_PREFIX = 'TS';

    public static $TRANS_SELL_OUT = 'TS02';

    public static $PRODUCT_STATUS_NOT_START = 'PRS01';
    public static $PRODUCT_STATUS_ON_SALE = 'PRS02';
    public static $PRODUCT_STATUS_SELL_OUT = 'PRS03';
    public static $PRODUCT_STATUS_RESCINDED = 'PRS04';
    public static $PRODUCT_STATUS_REVOKED = 'PRS05';
    
    const SECKILL_STATUS = 'PRS06';
    const PRODUCT_SECKILL_START = 'PRS07';
    const PRODUCT_SECKILL = 'PRS08';
    const PRODUCT_SECKILL_END = 'PRS09';
    const PRODUCT_WAITING_AUDIT = 'PRS10'; //待审核

    const ORDINARY_TYPE = 'PRT01'; // 普通
    const SECKILL_TYPE = 'PRT02'; //秒杀

    /**
     * 创建产品和卖单
     *
     * @param   $price 单价
     * @param   $count 数量
     * @param   $coinType 代币类型
     * @param   $starttime 开始时间
     * @param   $name 产品名称
     * @param   $type 类型
     * @param   $completionTime 结束时间
     * @author  zhoutao
     * @version 0.1
     * @date    2017.4.27
     * 
     * 增加redis 锁
     * @author  zhoutao
     * @date    2017.10.10
     * 
     * 取比例因子改成从projectInfoData取
     * @author  zhoutao
     * @date    2017.10.19
     */
    private function add($price, $count, $coinType, $starttime, $name, $type, $completionTime)
    {
        $userid = $this->session->userid;
        $lockData = new LockData();
        $key = "createProduct" . $userid;
        $lockData->lock($key);

        $docNo = new DocNoMaker();
        $no = $docNo->Generate(self::$PRODUCT_NO_PREFIX);
        $userCoinJournalNo = $docNo->Generate(self::$USER_COIN_JOURNAL_NO_PREFIX);
        $transactionSellNo = $docNo->Generate(self::$TRANS_SELL_NO_PREFIX);

        $userData = new UserData();
        $userInfo = $userData->get($userid);
        $userType = $userInfo->user_type;

        $status = InfoData::PRODUCT_WAITING_AUDIT;

        $userTypeData = new UserTypeData();
        $sysConfigKey = $userTypeData->getData($userid);

        $feeType = $sysConfigKey[UserTypeData::$CASH_SELL_FEE_TYPE];
        $feeRate = $sysConfigKey[UserTypeData::$CASH_SELL_FEE_RATE];
        $freezetime = $sysConfigKey[UserTypeData::$PRODUCT_FREEZETIME];

        //取出比例因子
        $projectData = new ProjectInfoData;
        $projectInfo = $projectData->getByNo($coinType);
        $showCoinScale = $projectInfo->project_scale;

        //显示价格 = 输入价格 显示数量 = 输入数量
        $toUserShowPrice = $price;
        $toUserShowCount = $count;

        //价格 = 显示价格 ／ 比例因子 数量 = 显示数量 * 比例因子
        $price = $toUserShowPrice / $showCoinScale;
        $count = $toUserShowCount * $showCoinScale;
        $amount = $price * $count;

        $date = date('Y-m-d H:i:s');
        $sellData = new CoinSellData();
        $res = $sellData->addSellOrder($count, $price, $coinType, $userCoinJournalNo, $transactionSellNo, $date, $toUserShowPrice, $toUserShowCount);

        if ($res === false) {
            $lockData->unlock($key);
            return false;
        }

        $model = $this->newitem();
        $model->product_no = $no;
        $model->product_price = $toUserShowPrice;
        $model->product_count = $toUserShowCount;
        $model->product_coin = $coinType;
        $model->product_starttime = $starttime;
        $model->product_name = $name;
        $model->product_status = $status;
        $model->product_owner = $userid;
        $model->product_feetype = $feeType;
        $model->product_feerate = $feeRate;
        $model->product_voucherenable = 1;
        $model->product_amount = $amount;
        $model->product_sellno = $transactionSellNo;
        $model->product_frozentime = $freezetime;
        $model->product_type = $type;
        $model->product_completiontime = $completionTime;
        $this->create($model);

        $lockData->unlock($key);
        return $model;
    }

    /**
     * 购买产品
     *
     * @param  $no 产品号
     * @param  $count 数量
     * @param  $_voucherNo 现金券号
     * @param  $_preNo 预购单号
     * @author zhoutao
     * @date   2017.8.24
     */ 
    public function buyProduct($no, $count, $_voucherNo, $_preNo = '')
    {


        $lockData = new LockData();
        $key = "buyProduct".$no;



        if ($lockData->lock($key)===false) {
            return ErrorData::$SELL_COUNT_NOT_ENOUGH;
        }
        $productInfo = $this->getByNo($no);

        $sellNo = $productInfo->product_sellno;
        $freezetime = $productInfo->product_frozentime;

        $session = resolve('App\Http\Utils\Session');
        $session->productFreezettime = $freezetime;

        $voucherNo = '';
        if ($productInfo->product_voucherenable) {
           
            $voucherNo = $_voucherNo;
        }

        if ($count < 0.01) {
             $lockData->unlock($key);
            return ErrorData::$BUY_COUNT_LARGE;
        }

        //声称流水单据号
        $docNo = new DocNoMaker();
        $transactionBuyNo = $docNo->Generate('TB');

        //查找卖单
       
        $sellData = new TranactionSellData();
        $sellRes = $sellData->getShowSell($sellNo);
        
        if ($sellRes['surplusCount'] < $count) {
             $lockData->unlock($key);
            return ErrorData::$SELL_COUNT_NOT_ENOUGH;
        }

        if (bccomp($sellRes['surplusCount'] - $count, 0.01, 2) == -1 && bccomp($count, intval($sellRes['surplusCount']) != 0)) {
             $lockData->unlock($key);
            // return ErrorData::$BUY_SURPLUS_COUNT;
        }

        //单价
        $price = $sellRes['price']; //每份价格

        //代币类型
        $coin = $sellRes['coinType'];
        $date = date('Y-m-d H:i:s');

        DB::beginTransaction();
        //执行挂买单业务
        $userCashBuyData = new UserCashBuyData();
        $userCashBuy = $userCashBuyData->addBuyOrder($transactionBuyNo, $count, $price, $coin, $date, $voucherNo, TranactionBuyData::LEVEL_TYPE_PRODUCT);
        if ($userCashBuy === 806001) {
            $lockData->unlock($key);
            return ErrorData::$USER_CASH_NOT_ENOUGH;
        } elseif ($userCashBuy === 806002) {
            $lockData->unlock($key);
            return ErrorData::$LEVEL_ONE_NOT_BUY;
        }
        
        //调用成交查看是否有可成交
        $transactionOrderData = new TranactionOrderData();
        
        $count = $transactionOrderData->buyProduct($count, $price, $transactionBuyNo, $sellNo, $voucherNo, $date);
        
        if ($count === false) {
            DB::rollBack();
        }

        //修改状态
        $sellInfo = $sellData->getByNo($sellNo);
        $sellStatus = $sellInfo->sell_status;
        if ($sellStatus == self::$TRANS_SELL_OUT) {
            //修改产品的状态
            $productInfo = $this->getByNo($no);
            if ($productInfo->product_status == self::$PRODUCT_STATUS_ON_SALE) {
                $productInfo->product_status = self::$PRODUCT_STATUS_SELL_OUT;
                $productInfo->product_endtime = $date;
                $this->save($productInfo);
            }
        }

        $res['count'] = $count;
        $res['order'] = $transactionOrderData->getInfo($coin);

        if (!empty($_preNo)) {
            $preorderData = new PreOrderData;
            $preorderData->saveStatus($_preNo, PreOrderData::BOUGHT_STATUS);
            $preorderData->saveBuyNo($_preNo, $transactionBuyNo);
        }

        DB::commit();
        $lockData->unlock($key);
        return $res;
    }

    /**
     * 查询产品详细
     *
     * @param  $productNo 产品号
     * @author zhoutao
     * @date   2017.9.8
     * 
     * 增加一些参数
     * @author zhoutao
     * @date   2017.9.22
     * 
     * 计算剩余数量使用了bcsub
     * @author zhoutao
     * @date   2017.9.26
     */ 
    public function getProduct($productNo)
    {
        $productInfo = $this->getByNo($productNo);
        $productPrice = $productInfo->product_price;
        $productName = $productInfo->product_name;
        $coinType  = $productInfo->product_coin;
        $productFeeRate = $productInfo->product_feerate;
        $endtime = $productInfo->product_endtime;
        $productStatus = $productInfo->product_status;
        
        

        switch ($productInfo->product_feetype) {
        case $this::$SELL_FEE_TYPE_FREE:
            $productFeeRate = 0;
            break;
        case $this::$SELL_FEE_TYPE_IN:
            $productFeeRate = $productInfo->product_feerate;
            break;
        case $this::$SELL_FEE_TYPE_OUT:
            $productFeeRate = $productInfo->product_feerate;
            break;
        default:
            break;
        }

        //查询卖单
        $sellNo = $productInfo->product_sellno;
        $sellData = new TranactionSellData();
        $sellInfo = $sellData->getByNo($sellNo);
        $sellCount = $sellInfo->sell_touser_feecount;
        $sellTranscount = $sellInfo->sell_transcount / $sellInfo->sell_scale;
        $sellSurplusCount = bcsub(floatval($sellInfo->sell_touser_feecount), floatval($sellTranscount), 5);
        $userTypeData = new UserTypeData();
        $sysConfigs = $userTypeData->getData($this->session->userid);

        //查询项目
        $projectInfoData = new projectInfoData();
        $projectInfo = $projectInfoData->getByNo($coinType);
        $projectInfoAdapter = new ProjectInfoAdapter;
        $res = $projectInfoAdapter->getDataContract($projectInfo);
        $res['productIsStart'] = $productStatus == InfoData::$PRODUCT_STATUS_NOT_START ? false : true;
        $res['productPrice'] = $productPrice;
        $res['productName'] = $productName;
        $res['productFeeRate'] = $sysConfigs[UserTypeData::$CASH_BUY_FEE_RATE];
        $res['productCount'] = $sellCount;
        $res['productSurplusCount'] = $sellSurplusCount;
        
        // $res['rose'] = 500; //涨幅
        // $res['investment'] = $res['investment'];
        $res['endTime'] = $endtime;

        $productAdapter = new InfoAdapter();
        $productInfo = $productAdapter->getDataContract($productInfo);
        $res['product'] = $productInfo;

        //已购人数
        $countUser = $this->getCountUser($sellNo);
        $res['orderUser'] = $countUser[0]->countUser;

        return $res;
    }

    /**
     * 查询产品的代币类型
     *
     * @param   $productNo 产品编号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.2
     */
    public function getCoinType($productNo)
    {
        $productInfo = $this->getByNo($productNo);
        if ($productInfo == null) {
            return null;
        }
        return $coinType = $productInfo->product_coin;
    }

    /**
     * 把达到开始时间的产品，状态修改为开始
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function productStart()
    {
        //查找开始时间到的产品
        $products = $this->getStartProduct();

        //循环改动这些产品的状态
        $status = $this::$PRODUCT_STATUS_ON_SALE;
        foreach ($products as $product) {
            if ($product->product_status == $this::$PRODUCT_STATUS_NOT_START) {
                // info(json_encode($product));
                $this->saveStatus($product->product_no, $status);
            }
        }
    }

    /**
     * 查询开始时间小于现在的产品
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function getStartProduct()
    {
        $model = $this->modelclass;
        $startTime = date('Y-m-d H:i:s');
        $products = $model::where('product_starttime', '<=', $startTime)->get();
        return $products;
    }

    /**
     * 修改产品的状态
     *
     * @param   $productNo 产品编号
     * @param   $status 修改后的状态
     * @author  zhoutao
     * @version 0.1
     */
    public function saveStatus($productNo, $status)
    {
        $productInfo = $this->getByNo($productNo);
        $productInfo->product_status = $status;
        $res = $this->save($productInfo);
        return $res;
    }
    
    /**
     * 查询产品的卖单号
     *
     * @param   $productNo 产品编号
     * @author  zhoutao
     * @version 0.1
     * @date    2017.5.2
     */
    public function getSellNo($productNo)
    {
        $productInfo = $this->getByNo($productNo);
        if ($productInfo == null) {
            return null;
        }
        return $coinType = $productInfo->product_sellno;
    }

    /**
     * 用卖单号获取产品名称
     *
     * @param   $sellNo 卖单号
     * @author  zhoutao
     * @version 0.1
     */
    public function getProductName($sellNo)
    {
        $where['product_sellno'] = $sellNo;
        $model = $this->modelclass;
        $info = $model::where($where)->first();
        if ($info == null) {
            return null;
        }
        return $info->product_name;
    }

    /**
     * 用卖单号获取产品单号
     *
     * @param   $sellNo 卖单号
     * @author  zhoutao
     * @version 0.1
     */
    public function getProductNo($sellNo)
    {
        $where['product_sellno'] = $sellNo;
        $model = $this->modelclass;
        $info = $model::where($where)->first();
        if ($info == null) {
            return null;
        }
        return $info->product_no;
    }


    /**
     * 计算认购人数
     */
    public function getCountUser($sellNo)
    {
        return DB::select(DB::raw("SELECT count(distinct order_buy_userid) as countUser from transaction_order where `order_sell_no` = '{$sellNo}'"));
    }

    /**
     * 撤销产品
     *
     * @author zhoutao
     * @date   2017.9.26
     * 
     * 增加了redis锁
     */
    public function revoke($productNo)
    {
        $lockData = new LockData();
        $key = "revokeProduct".$productNo;
        $lockData->lock($key);

        $productInfo = $this->getByNo($productNo);

        $sellNo = $productInfo->product_sellno;
        $sellData = new TranactionSellData();
        $count = $sellData->revokeProduct($sellNo);
        $date = date('Y-m-d H:i:s');
        if ($count != 0) {
            $productInfo->product_count = $count;
            $productInfo->product_amount = $count * $productInfo->product_price;
            $productInfo->product_status = InfoData::$PRODUCT_STATUS_SELL_OUT;
            $productInfo->product_endtime = $date;
            $productInfo->product_revoketime = $date;
        } else {
            $productInfo->product_status = InfoData::$PRODUCT_STATUS_REVOKED;
            $productInfo->product_revoketime = $date;
        }
        
        $this->save($productInfo);
        $lockData->unlock($key);
    }

    /**
     * 查询所有的产品列表
     *
     * @param  $fileter
     * @param  $pageSize
     * @param  $pageIndex
     * @author zhoutao
     */
    public function getProducts($filter, $pageSize, $pageIndex)
    {
        $orderArray = ['asc','desc'];
        $model = $this->modelclass;
        $res = [];
        $tmp = null;
        $tmp = $model::whereIn('product_status', [self::$PRODUCT_STATUS_ON_SALE,self::$PRODUCT_STATUS_NOT_START])->where('product_type', InfoData::ORDINARY_TYPE)
                        ->orWhere(
                            function ($query) {
                                $query->where('product_type', InfoData::SECKILL_TYPE)
                                    ->whereIn('product_status', [InfoData::$PRODUCT_STATUS_ON_SALE,InfoData::$PRODUCT_STATUS_NOT_START]);
                            }
                        );
        if (is_array($filter)) {
            foreach ($filter as $col => $val) {
                if (!in_array($val, $orderArray)) {
                    $tmp = $tmp->where($col, $val);
                }
            }
        }
        $res['totalSize'] = $model::whereIn('product_status', [self::$PRODUCT_STATUS_NOT_START,self::$PRODUCT_STATUS_ON_SALE,self::$PRODUCT_STATUS_SELL_OUT])->count();
        $res["pageSize"]=$pageSize;
        $res["pageCount"]= ($res['totalSize']-$res['totalSize']%$res["pageSize"])/$res["pageSize"] +($res['totalSize']%$res["pageSize"]===0?0:1);
        $pageIndex = $pageIndex > $res['pageCount'] ? $res['pageCount'] : $pageIndex;
        $res["pageIndex"]=$pageIndex;
        
        $items = $tmp->orderBy('product_type', 'desc')->orderBy('product_status', 'desc')->orderBy('created_at', 'desc')
            ->offset($pageSize*($pageIndex-1))
            ->limit($pageSize)
            ->get();
        $res['items'] = [];
        foreach ($items as $col => $val) {
            $res['items'][] = $val;
        }

        if (count($items->toArray()) < $pageSize) {
            $count = $pageSize + $tmp->offset(0)->count();
            // dump(count($items->toArray()));
            // dump($tmp->offset(0)->count());
            // dump($res['totalSize']);
            $page =  ($pageIndex  - ($count - $count % $pageSize) / $pageSize)  ;
            // dump($page);
            if ($page==0
            ) {
                $offset =0;
            } else {
                $offset =$page * $pageSize - ($count % $pageSize === 0  ?
                        0:($count % $pageSize)) ;
            }
            //            $offset = ($pageIndex - ($count - $count % $pageSize) / $pageSize - 1) * $pageSize + $count % $pageSize;
            $limit = $pageSize - count($items->toArray());
            $itemsTwo = $model::whereIn('product_status', [self::$PRODUCT_STATUS_SELL_OUT])
                            ->where('product_type', InfoData::ORDINARY_TYPE)
                            ->orWhere(
                                function ($query) {
                                    $query->where('product_type', InfoData::SECKILL_TYPE)
                                        ->where('product_status', InfoData::$PRODUCT_STATUS_SELL_OUT);
                                }
                            )
                            ->orderBy('product_status', 'asc')->orderBy('created_at', 'desc')
                            ->offset($offset)
                            ->limit($limit)
                            ->get();
            foreach ($itemsTwo as $col => $val) {
                $res['items'][] = $val;
            }
        }
        // dump($pageSize*($pageIndex-1));
        // dump($offset,$limit);die;
        // foreach ($res['items'] as $val) {
        //     dump($val->id);
        // }
        // die;
        //把秒杀状态改变
        // foreach ($res['items'] as $val) {
        //     if ($val->product_type == infoData::SECKILL_TYPE) {
        //         switch ($val->product_status) {
        //             case infoData::$PRODUCT_STATUS_NOT_START :
        //                 $val->product_status = infoData::PRODUCT_SECKILL_START;
        //                 break;
        //             case infoData::$PRODUCT_STATUS_ON_SALE :
        //                 $val->product_status = infoData::PRODUCT_SECKILL;
        //                 break;
        //             case infoData::$PRODUCT_STATUS_SELL_OUT :
        //                 $val->product_status = infoData::PRODUCT_SECKILL_END;
        //                 break;
        //             default:
        //                 break;
        //         }
        //     }
        // }

        return $res;
    }

    /**
     * 秒杀结束
     */
    public function productSeckillEnd()
    {
        $products = $this->getCompletionProduct();
        if (count($products) > 0) {
            foreach ($products as $val) {
                if ($val->product_status == InfoData::$PRODUCT_STATUS_ON_SALE) {
                    $this->revoke($val->product_no);
                }
                
            }
        }
        
        
    }

    /**
     * 查询秒杀结束的项目
     */
    public function getCompletionProduct()
    {
        $model = $this->modelclass;
        $endTime = date('Y-m-d H:i:s');
        $products = $model::where('product_completiontime', '<=', $endTime)
                            ->where('product_type', InfoData::SECKILL_TYPE)->get();
        return $products;
    }


    /**
     * 查询趋势曲线
     *
     * @param  $no 产品单号
     * @author zhoutao
     * 1 用产品单号 查询产品详细
     * 2 取出代币类型 调用曲线data 查询出来
     * 3 循环到数组里面
     */
    public function getCurves($no)
    {
        $info = $this->getByNo($no);
        $trends = [];
        if (!empty($info)) {
            $coinType = $info->product_coin;
            $trendData = new TrendData();
            $trendAdapter = new TrendAdapter;
            $curves = $trendData->getCurves($coinType, 10);
                $trends = [];
            if (count($curves) > 0) {
                foreach ($curves as $v) {
                    $trend = $trendAdapter->getDataContract($v);
                    $trends[] = $trend;
                }
            }
        }
        
        return $trends;
    }


    /**
     * 查询项目坐标
     *
     * @param  $productNo 产品单号
     * @author zhoutao
     * 
     * 1 用产品单号 查询产品详细
     * 2 拿到代币类型 分别查询房产坐标和学校坐标
     * 3 转换数据
     * 4 返回
     */
    public function getCoordinate($productNo)
    {
        $info = $this->getByNo($productNo);

        $res = [];
        if (!empty($info)) {
            $coordinateData = new CoordinateData;
            $coordinateAdapter = new CoordinateAdapter;
            $coinType = $info->product_coin;
            
            $house = $coordinateData->getHouse($coinType);

            if (!empty($house)) {
                $house = $coordinateAdapter->getDataContract($house);
            }

            $res['house'] = $house;


            $schools = $coordinateData->getSchools($coinType);

            $schoolCoordinates = [];
            if (count($schools) > 0) {
                foreach ($schools as $school) {
                    $schoolCoordinate = $coordinateAdapter->getDataContract($school);
                    $schoolCoordinates[] = $schoolCoordinate;
                }
            }
            $res['schools'] = $schoolCoordinates;
            
        }

        return $res;
    }

    public function getProductByCoinType($coinType,$setCount)
    {
        $transactionSellData=new TranactionSellData;
        $model=$this->newitem();
        $res=$model->where('product_coin', $coinType)->where('product_status', 'PRS02')->get();
        if($res==null) {
            return null;
        }
        else
        {
            foreach($res as $value)
            {
                $count=$value->product_count;
                $sellNo=$value->product_sellno;
                $sellCount=$transactionSellData->getTranscount($sellNo);
                $remainCount=$count - $sellCount * 100;
                if($remainCount>=$setCount) {
                    $result=$value;
                    return $result;
                    break;
                }
                else
                {
                    $result=null;
                }
            }
            return $result;
        }
    }
}
