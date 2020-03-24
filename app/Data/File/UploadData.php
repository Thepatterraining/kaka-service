<?php
namespace App\Data\File;

use App\Data\IDataFactory;
use App\Data\Utils\DocMD5Maker;
use App\Data\Product\InfoData;
use App\Data\Item\InfoData as ItemInfoData;
use App\Data\User\UserTypeData;
use App\Data\User\UserData;
use App\Http\Adapter\User\UserAdapter;
use App\Data\Utils\DocNoMaker;
use App\Data\Trade\TranactionOrderData;
use App\Data\User\CashOrderData;

class UploadData extends IDatafactory
{

    protected $modelclass = 'App\Model\File\Upload';

    protected $no = '_id';

    public function add($imguri, $base64File)
    {
        $model = $this->newitem();
        $model->imguri = $imguri;
        $model->imgbase64 = $base64File;
        $this->save($model);
    }
}
