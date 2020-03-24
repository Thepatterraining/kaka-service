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
interface IGettedVoucher
{



    /**
     * 返回用户得到券后的操作
     *
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.12
     * @param   $voucherNo -- 代金券号 
     * @param   $storageInfo storage 的info
     * @param   $userid -- 用户id
     **/
    public function gettedVoucher($voucherNo, $storageInfo, $userid);


}