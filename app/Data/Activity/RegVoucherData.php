<?php
namespace App\Data\Activity;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Utils\DocNoMaker;
use App\Data\Trade\TranactionSellData;

class RegVoucherData extends IDatafactory
{

    
    /**
     * 注册发送现金券
     *
     * @param   $userid 用户id
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function Activity($userid, $filter)
    {
        $where['activity_status'] = 'AS01';
        $where['activity_filter'] = $filter;
        $activiInfo = new InfoData();
        $list = $activiInfo->findForUpdate($where);
        if ($list == null) {
            return false;
        }
        $activiNo = $list->activity_no;
        //查字表
        $itemData = new ItemData();
        $itemlist = $itemData->getItem($activiNo);
        foreach ($itemlist as $k => $v) {
            $voucherNo = $v->activity_itemno;

            //查现金券
            $voucherInfoData = new VoucherInfoData();
            $voucherInfo = $voucherInfoData->getByNo($voucherNo);
            if ($voucherInfo == null) {
                continue;
            }
            $timespan = $voucherInfo->voucher_timespan;
            $outtime = date('U') + $timespan;

            //发现金券
            $voucherData = new VoucherStorageData();
            $no = '1';
            $voucherData = $voucherData->addStorage($no, $voucherNo, $activiNo, $userid, $outtime);
            if ($voucherData === false) {
                return false;
            }
            //通知用户
            $this->AddEvent("Voucher_Check", $userid, $voucherNo);

            //更新现金券发放数量
            $voucherRes = $voucherInfoData->saveVoucherCount($voucherInfo, 1);
            if ($voucherRes === false) {
                return false;
            }

            //更新活动实际发生数量
            $activiInfoRes = $activiInfo->saveCount($where, 1);
            if ($activiInfoRes === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * 查询可用券
     *
     * @param   $price 总价
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     */
    public function getUserVoucher($price)
    {
        $voucherInfoData = new VoucherInfoData();
        $model = $voucherInfoData->newitem();
        $where['activity_status'] = 'AS01';
        $activiInfo = new InfoData();
        $list = $activiInfo->findForUpdate($where);
        if ($list == null) {
            return false;
        }
        $activiNo = $list->activity_no;
        //查字表
        $itemData = new ItemData();
        $itemlist = $itemData->getItem($activiNo);
        foreach ($itemlist as $v) {
            $voucherNo[] = $v->activity_itemno;
        }
        $info = $model::where('voucher_val1', '<', $price)
            ->whereIn('vaucher_no', $voucherNo)
            ->orderBy('voucher_val1', 'desc')->first();
        return $info;
    }

    /**
     * 查询产品可用券
     *
     * @param   $count 数量
     * @param   $sellNo 卖单号
     * @return  bool
     * @author  zhoutao
     * @version 0.1
     * 
     * 增加了产品单号参数
     * @param   $productNo 产品单号
     * @author  zhoutao
     * @date    2017.9.14
     * 
     * 去掉了产品单号参数
     * @author  zhoutao
     * @date    2017.10.16
     */
    public function getUserProductVoucher($count, $sellNo)
    {
        $sellData = new TranactionSellData();
        $sellInfo = $sellData->getByNo($sellNo);
        $sellPrice = $sellInfo->sell_touser_feeprice;
        $amount = $sellPrice * $count;
        $info = $this->getCoupon($amount, $sellNo);
        return $info;
    }

    public function getVoucher($amount)
    {
        //查询用户有哪些可用券
        $voucherInfoData = new VoucherInfoData();
        $model = $voucherInfoData->newitem();
        $voucherStorageData = new VoucherStorageData();
        $vouchers = $voucherStorageData->getVoucherNos();
        if (empty($vouchers)) {
            return $vouchers;
        }
        foreach ($vouchers as $voucher) {
            $voucherNos[] = $voucher->vaucherstorage_voucherno;
        }
        $info = $model::where('voucher_val1', '<', $amount)->whereIn('vaucher_no', $voucherNos)->orderBy('voucher_val1', 'desc')->first();
        
        return $info;
    }

    /**
     * 查询符合要求的现金券
     *
     * @param  $amount 金额
     * @param  $productNo 产品单号
     * @author zhoutao
     * @date   2017.9.14
     * 
     * 修复重复判断问题
     * @author zhoutao
     * @date   2017.9.16
     * 
     * 修复判空问题
     * @author zhoutao
     * @date   2017.9.18
     * 
     * 把产品单号改成卖单号
     * @author zhoutao
     * @date   2017.10.16
     */
    public function getCoupon($amount, $sellNo)
    {
        $sellData = new TranactionSellData;
        $sellInfo = $sellData->getByNo($sellNo);

        //查询用户有哪些可用券
        $voucherInfoData = new VoucherInfoData();
        $model = $voucherInfoData->newitem();
        $voucherStorageData = new VoucherStorageData();
        $storages = $voucherStorageData->getVoucherNos();
        if (empty($storages)) {
            return $storages;
        }
        $voucherFac = new \App\Data\Voucher\VoucherFactory;
        foreach ($storages as $storage) {
            $voucherNos[] = $storage->vaucherstorage_voucherno;
        }
        $vouchers = $model::where('voucher_val1', '<', $amount)->whereIn('vaucher_no', $voucherNos)->orderBy('voucher_val2', 'desc')->orderBy('voucher_val1', 'asc')->get();
        foreach ($vouchers as $voucher) {
            $usingVoucherData = $voucherFac->createVoucherModelUseing($voucher);
            if ($usingVoucherData->canUsingVoucher($storage->vaucherstorage_no, $sellInfo, $this->session->userid) === true) {
                return $voucher;
            }

        }
        return '';
        
    }
}
