<?php
namespace App\Data\Voucher; 
use App\Data\Voucher\DefaultVoucher ;

/**
 * 优惠券工厂
 *
 * @author zhoutao
 * @date   2017.9.14
 */
class VoucherFactory
{

    public function CreateVoucher($voucherInfoModel,$storageInfo)
    {


        $model_class = $voucherInfoModel->voucher_model;

        if(class_exists($model_class)== true) {
            $result = new $model_class();
        }else{
            $result = new DefaultVoucher();
        }

        $result->load_data($voucherInfoModel, $storageInfo);
        return $result ;

    }

    /**
     * 创建领取前置类
     *
     * @param  $voucherInfoModel 优惠券model
     * @author zhoutao
     * @date   2017.9.14
     */
    public function createVoucherModelGetting($voucherInfoModel)
    {
        $model_class = $voucherInfoModel->voucher_model_getting;
        if(class_exists($model_class)== true) {
            $result = new $model_class();
        }else{
            $result = new GetVoucher();
        }
        return $result ;
    }
    
    /**
     * 创建领取后置类
     *
     * @param  $voucherInfoModel 优惠券model
     * @author zhoutao
     * @date   2017.9.14
     */
    public function createVoucherModelGetted($voucherInfoModel)
    {
        $model_class = $voucherInfoModel->voucher_model_getted;
        if(class_exists($model_class)== true) {
            $result = new $model_class();
        }else{
            $result = new GettedVoucher();
        }
        return $result ;
    }

    /**
     * 创建使用前置类
     *
     * @param  $voucherInfoModel 优惠券model
     * @author zhoutao
     * @date   2017.9.14
     */
    public function createVoucherModelUseing($voucherInfoModel)
    {
        $model_class = $voucherInfoModel->voucher_model_useing;
        if(class_exists($model_class)== true) {
            $result = new $model_class();
        }else{
            $result = new UsingVoucher();
        }
        return $result ;
    }

    /**
     * 创建使用后置类
     *
     * @param  $voucherInfoModel 优惠券model
     * @author zhoutao
     * @date   2017.9.14
     */
    public function createVoucherModelUsed($voucherInfoModel)
    {
        $model_class = $voucherInfoModel->voucher_model_used;
        if(class_exists($model_class)== true) {
            $result = new $model_class();
        }else{
            $result = new UsedVoucher();
        }
        return $result ;
    }
}