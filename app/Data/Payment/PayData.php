<?php
namespace App\Data\Payment;

use App\Data\IDataFactory;

class PayData extends IDatafactory
{
    

    protected $modelclass = 'App\Model\Payment\Pay';

    public function getAllChannel()
    {
        $item=$this->newitem()->select('id')->get();
        return $item;
    }
}
