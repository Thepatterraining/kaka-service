<?php
namespace App\Data\Sys;

use App\Data\IDataFactory;
use App\Data\Utils\DocNoMaker;

class ClearData extends IDatafactory
{

    protected $modelclass = 'App\Model\Sys\Clear';

    /**
     * 添加清算记录
     *
     * @author  zhoutao
     * @version 0.1
     */
    public function add($userid, $price, $count, $coinType)
    {
        $model= $this->newitem();
        $docNo = new DocNoMaker;
        $no = $docNo->Generate('SCC');
        $model->clear_no = $no;
        $model->clear_coin_type = $coinType;
        $model->clear_amount = bcmul(strval($price), strval($count), 2);
        $model->clear_count = $count;
        $model->clear_price = $price;
        $model->clear_userid = $userid;
        return $no;
    }
}
