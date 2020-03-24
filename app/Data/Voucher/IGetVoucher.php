<?php
namespace App\Data\Voucher;


/**
 * 代金券接口
 *
 * @author  geyunfei@kakamf.com
 * @version 1.0
 * @date    Sep,6th,2017
 * 现金券接口定义
 **/
interface IGetVoucher
{



    /**
     * 返回用户是否可以领取该券，如果可以返回true 否则返回不可以的原因
     *
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.12
     * @param   $voucherNo -- 代金券号 
     * @param   $userid -- 用户id
     **/
    public function canGetVoucher($voucherNo, $userid);


}