<?php
namespace App\Data\Voucher;

use App\Data\Voucher\IUsedVoucher;

class FrozenVoucher implements IUsedVoucher
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
    public function UsedVoucher($storageNo,$docInfo,$userid)
    {
        
    }
}