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
interface IUsedVoucher
{



    /**
     * 用券后调用
     *
     * @author  zhoutao
     * @version 1.0
     * @date    2017.9.13
     * @param   $storageNo -- 用户持有现金券号 
     * @param   $docInfo 
     * @param   $userid -- 用户id
     **/
    public function UsedVoucher($storageNo,$docInfo,$userid);


}