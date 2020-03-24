<?php
namespace App\Data\Product;

use App\Data\IDataFactory;
use App\Data\Sys\ErrorData;
use App\Data\Trade\CoinSellData;
use App\Data\Trade\TranactionOrderData;
use App\Data\Trade\TranactionSellData;
use App\Data\Trade\UserCashBuyData;
use App\Data\User\UserData;
use App\Data\User\UserTypeData;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Http\Adapter\Product\InfoAdapter;
use App\Data\Item\InfoData as ItemData;
use App\Http\Adapter\Item\InfoAdapter as ItemAdapter;
use App\Data\User\CoinAccountData;
use App\Data\Sys\LockData;
use Illuminate\Support\Facades\DB;
use App\Http\Adapter\Activity\VoucherInfoAdapter;
use App\Data\Activity\RegVoucherData;
use App\Data\Activity\VoucherStorageData;
use App\Http\Adapter\Activity\VoucherStorageAdapter;
use App\Data\Cash\UserRechargeData;
use App\Data\Utils\Formater;
use App\Data\Trade\TransactionBuySellData;
use App\Data\CashRecharge\CashRechargeFactory;

class PreOrderData extends IDatafactory
{

    protected $modelclass = 'App\Model\Product\PreOrder';

    protected $no = 'preorder_no';

    const NEWLY_BUILD_STATUS = 'PROST00';
    const RECHARGED_STATUS = 'PROST01';
    const BOUGHT_STATUS = 'PROST02';

    /**
     * 增加预购单
     *
     * @param  $productNo 产品号
     * @param  $count
     * @param  $voucherNo
     * @param  $amount
     * @author zhoutao
     * 
     * 把产品单号改成卖单号
     * @author zhoutao
     * @date   2017.10.16
     */
    public function add($sellNo, $count, $voucherNo, $amount)
    {
        $docNo = new DocNoMaker();
        $no = $docNo->Generate('PREO');
        $model = $this->newitem();
        $model->preorder_no = $no;
        $model->preorder_product = $sellNo;
        $model->preorder_count = $count;
        $model->preorder_voucherinfo = $voucherNo;
        $model->preorder_userid = $this->session->userid;
        $model->preorder_amount = $amount;
        $model->preorder_status = PreOrderData::NEWLY_BUILD_STATUS;
        $this->create($model);
        return $no;
    }

    /**
     * 预购产品
     *
     * @param  $productNo 产品号
     * @param  $count 数量
     * @param  $voucherNo 优惠券号
     * @author zhoutao
     * 
     * 修改了查询最优现金券的参数
     * @author zhoutao
     * @date   2017.9.14
     * 
     * 修改产品单号为卖单号
     * @param  $sellNo 卖单号
     * @author zhoutao
     * @date   2017.10.16
     */
    public function wechatBuyPreProduct($sellNo, $count, $voucherNo)
    {
        $lockData = new LockData();
        $key = 'wechatBuyPreProduct'.$sellNo;
        $lockData->lock($key);

        $productData = new InfoData();
        $voucherStorageData = new VoucherStorageData();
        $voucherStorageAdapter = new VoucherStorageAdapter();
        $sellData = new TranactionSellData();
        $data = new RegVoucherData();
        $adapter = new VoucherInfoAdapter();
        if (empty($voucherNo) || $voucherNo == 'null') {
            //查找适合的优惠券
            $sellRes = $sellData->isVoucher($sellNo);
            //不可用
            if ($sellRes !== false) {
                $res = $data->getUserProductVoucher($count, $sellNo);
                if (!empty($res)) {
                    $res = $adapter->getDataContract($res);
                    $voucherNo = array_get($res, 'no');
                    $voucherStorage = $voucherStorageData->getStorage($voucherNo);
                    $voucherStorage = $voucherStorageAdapter->getDataContract($voucherStorage);
                    $voucherNo = $voucherStorage['no'];
                }
            }
        }

        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $feeRate = $sysConfigs[UserTypeData::$CASH_BUY_FEE_RATE];

        $sellInfo = $sellData->getByNo($sellNo);
        $price = $sellInfo->sell_touser_feeprice;
        $fee = $price * $count * $feeRate;
        $fee = Formater::ceil($fee);
        // info('price'.$price);
        // info('count'.$count);
        // info('voucehrCash'.$voucherCash);
        // info('fee'.$fee);
        if (empty($voucherNo) || $voucherNo == 'null') {
            $voucherCash = 0;
        } else {
            $voucherCash = $voucherStorageData->getVoucherReduceCash($voucherNo, $price * $count + $fee);
        }
        $amount = $price * $count - $voucherCash + $fee;
        $amount = Formater::ceil($amount);
        $preOrderData = new PreOrderData();
        $preNo = $preOrderData->add($sellNo, $count, $voucherNo, $amount);
        $pre['preNo'] = $preNo;
        $pre['amount'] = $amount;

        $lockData->unlock($key);
        return $pre;
    }

    /**
     * 获取产品金额
     *
     * @param  $productNo 产品单号
     * @param  $count 数量
     * @author zhoutao
     * 
     * 修改了查询最优现金券的参数
     * @author zhoutao
     * @date   2017.9.14
     * 
     * 修改产品单号为卖单号
     * @param  $sellNo 卖单号
     * @author zhoutao
     * @date   2017.10.16
     */
    public function getSellAmount($sellNo, $count)
    {
        $lockData = new LockData();
        $key = 'getSellAmount'.$sellNo;
        $lockData->lock($key);

        $productData = new InfoData();
        $voucherStorageData = new VoucherStorageData();
        $voucherStorageAdapter = new VoucherStorageAdapter();
        $sellData = new TranactionSellData();
        $data = new RegVoucherData();
        $adapter = new VoucherInfoAdapter();

        //查找适合的优惠券
            $sellRes = $sellData->isVoucher($sellNo);
            //不可用
            $voucherNo = null;
        if ($sellRes !== false) {
            $res = $data->getUserProductVoucher($count, $sellNo);
            if (!empty($res)) {
                $res = $adapter->getDataContract($res);
                $voucherNo = array_get($res, 'no');
                $voucherStorage = $voucherStorageData->getStorage($voucherNo);
                $voucherStorage = $voucherStorageAdapter->getDataContract($voucherStorage);
                $voucherNo = $voucherStorage['no'];
            }
        }

        $userTypeData = new UserTypeData;
        $sysConfigs = $userTypeData->getData($this->session->userid);
        $feeRate = $sysConfigs[UserTypeData::$CASH_BUY_FEE_RATE];

        $sellInfo = $sellData->getByNo($sellNo);
        $price = $sellInfo->sell_touser_feeprice;
        $fee = $price * $count * $feeRate;
        $fee = Formater::ceil($fee);

        if (empty($voucherNo) || $voucherNo == 'null') {
            $voucherCash = 0;
        } else {
            $voucherCash = $voucherStorageData->getVoucherReduceCash($voucherNo, $$price * $count + $fee);
        }

        $amount = $price * $count - $voucherCash + $fee;
        $amount = Formater::ceil($amount);
        $lockData->unlock($key);
        return $amount;
    }


    /**
     * 微信购买产品
     *
     * @param  $preNo 预购单号
     * @param  $channelid 通道id
     * @author zhoutao
     * 
     * 调用产品购买改成调用购买卖单
     * @author zhoutao
     * @date   2017.10.17
     */
    public function wechatBuyProduct($preNo, $channelid)
    {
        $lockData = new LockData();
        $key = 'wechatBuyProduct'.$preNo;
        $lockData->lock($key);

        $preOrderData = new PreOrderData;
        $transactionBuySellData = new TransactionBuySellData;
        $preOrderInfo = $preOrderData->getByNo($preNo);
        // info('preNo'.$preNo);
        // info(json_encode($preOrderInfo));
        if (empty($preOrderInfo)) {
            return null;
        }
        $userid = $preOrderInfo->preorder_userid;
        $this->session->userid = $userid;
        $voucherNo = $preOrderInfo->preorder_voucherinfo;
        $count = $preOrderInfo->preorder_count;
        $sellNo = $preOrderInfo->preorder_product;
        $amount = $preOrderInfo->preorder_amount;
        $status = $preOrderInfo->preorder_status;

        if ($status == PreOrderData::NEWLY_BUILD_STATUS) {
            //充值
            $rechargeFac = new CashRechargeFactory;
            $rechargeData = $rechargeFac->createData($channelid);
            $rechargeRes = $rechargeData->recharge($amount);
            if ($rechargeRes['success'] === false) {
                return $rechargeRes;
            }
            $rechargeData->rechargeTrue($rechargeRes['msg']['rechargeNo']);
            $this->saveStatus($preNo, PreOrderData::RECHARGED_STATUS);
            $this->saveRechargeNo($preNo, $rechargeRes['msg']['rechargeNo']);
        }

        if ($status == PreOrderData::NEWLY_BUILD_STATUS || $status == PreOrderData::RECHARGED_STATUS) {
            //购买
            // info('开始购买');
            $transactionBuySellData->buySell($sellNo, $count, $voucherNo, $preNo);
        }

        $lockData->unlock($key);
    }

    public function saveStatus($no, $status)
    {
        $info = $this->getByNo($no);
        $info->preorder_status = $status;
        $this->save($info);
    }

    public function saveRechargeNo($no, $rechargeNo)
    {
        $info = $this->getByNo($no);
        $info->preorder_rechargeno = $rechargeNo;
        $this->save($info);
    }

    public function saveBuyNo($no, $buyNo)
    {
        $info = $this->getByNo($no);
        $info->preorder_buyno = $buyNo;
        $this->save($info);
    }
}
